Date.prototype.parseString = function(){
    let year = this.getFullYear();
    let month = this.getMonth() + 1;
    let date = this.getDate();

    if(month < 10) month = "0" + month;
    if(date < 10) date = "0" + date;
    
    return `${year}-${month}-${date}`;
}

String.prototype.time2sec = function(){
    let matches = this.match(/(?<hour>[0-9]{2}):(?<minute>[0-9]{2})/);
    let hour = parseInt(matches.groups.hour);
    let minute = parseInt(matches.groups.minute);
    return hour * 60 + minute;
}

Number.prototype.sec2time = function(){
    let hour = Math.floor(this / 60);
    let minute = this % 60;

    if(hour < 10) hour = "0" + hour;
    if(minute < 10) minute = "0" + minute;
    return `${hour}:${minute}`;
}

class Ajax {
    static get(url){
        return new Promise(res => {
            fetch(url)
            .then(v => v.text())
            .then(v => res(v));
        });
    }

    static getJSON(url){
        return new Promise(res => {
            fetch(url)
            .then(v => v.json())
            .then(v => res(v));
        });
    }

    static getImage(url){
        return new Promise(res => {
            fetch(url)
            .then(v => v.blob())
            .then(v => {
                let imageURL = URL.createObjectURL(v);
                res(imageURL);
            });
        });
    }

    static post(url, data = {}){
        let form = new FormData();
        for(let key in data){
            form.append(key, data[key]);
        }
        return new Promise(res => {
            fetch(new Request(url, {method: "post", body: form}))
            .then(v => v.json())
            .then(v => res(v));
        });
    }
}

window.addEventListener("load", async () => {
    // 다이얼 로그 불러오기
    let dialog = {
        login: await fetch("/dialog/login.html")
                    .then(v => v.text())
                    .then(v => {
                        let $contents = $(v);
                        $contents.dialog({
                            autoOpen: false,
                            resizable: false,
                            width: 480
                        });
                        return $contents;
                    }),
        join: await fetch("/dialog/join.html")
                    .then(v => v.text())
                    .then(v => {
                        let $contents = $(v);
                        $contents.dialog({
                            autoOpen: false,
                            resizable: false,
                            width: 480
                        });
                        return $contents;
                    }),
    }


    // 실시간으로 중복 아이디 검사
    let idChecking = () => new Promise(res => {
        Ajax.post("/sign-up/check-overlap", {identity: idInput.val()})
        .then(result => {
            if(result){
                idInput.prev()
                .text("중복된 아이디 입니다.")
                .show();
                res(false);
            }
            else {
                idInput.prev().hide();
                res(true);
            }
        }); 
    });
    let idInput = dialog.join.find("#join__userid");
    let idTimer = null;
    idInput.on("input", e => {
        if(idTimer) clearTimeout(idTimer);
        idTimer = setTimeout(idChecking, 500);
    });


    //  회원가입 다이얼로그 SUBMIT 이벤트
    dialog.join.find("form").on("submit", async function(e){
        e.preventDefault();

        let error = false;

        let elem__id = $(this).find("#join__userid");
        if(elem__id.val().trim() !== "") elem__id.prev().hide();
        else {
            elem__id.prev().text("아이디를 입력하세요.").show();
            error = true;
        }

        let check__id = await idChecking();
        if(check__id == false) error = true;
    
        let elem__pw = $(this).find("#join__password");
        let regex__pw = /^(?=.*[a-zA-Z].*)(?=.*[0-9].*)(?=.*[!@#$%^&*\(\)].*)[a-zA-Z0-9!@#$%^&*\(\)]{6,20}$/;
        if(regex__pw.test(elem__pw.val())) elem__pw.prev().hide();
        else {
            elem__pw.prev().show();
            error = true;
        }

        let elem__name = $(this).find("#join__username");
        let regex__name = /^[ㄱ-ㅎㅏ-ㅣ가-힣]{2,4}$/;
        if(regex__name.test(elem__name.val())) elem__name.prev().hide();
        else {
            elem__name.prev().show();
            error = true;
        }
        
        let elem__phone = $(this).find("#join__phone");
        let regex__phone = /^[0-9]+$/;
        if(regex__phone.test(elem__phone.val())) elem__phone.prev().hide();
        else {
            elem__phone.prev().show();
            error = true;
        }

        let elem__captcha = $(this).find("#join__captcha");
        let check__captcha = await Ajax.post("/sign-up/check-captcha", {input: elem__captcha.val()});
        if(check__captcha) elem__captcha.prev().hide();
        else {
            elem__captcha.prev().show();
            error = true;
        }

        if(error == false)
            this.submit();
    });

    
    // 회원가입 전화번호 이벤트
    dialog.join.find("#join__phone").on("input", function(e){
        let preview = dialog.join.find("#join__preview-phone");
        let input = this.value;

        if(input.length == 11) input = input.replace(/([0-9]{3})([0-9]{4})([0-9]{3})/, "$1-$2-$3")
        if(input.length == 10) input = input.replace(/([0-9]{3})([0-9]{3})([0-9]{3})/, "$1-$2-$3")
        if(input.length == 9)  input = input.replace(/([0-9]{2})([0-9]{3})([0-9]{3})/, "$1-$2-$3")
        
        preview.val(input);
    });

    // 캡챠 리로드 이벤트
    dialog.join.find("#join__captcha-reload").on("click", function(){
        console.log("click");
        Ajax.getImage("/sign-up/captcha").then(url => new Promise(res => {
            let image = new Image();
            image.id = "join__captcha-image"
            image.classList.add("w-100", "my-2")
            image.src = url;
            image.alt = "자동가입방지"
            image.onload = () => res(image);
        })).then(image => {
            let exist = document.querySelector("#join__captcha-image");
            console.log(exist);
            exist.parentElement.insertBefore(image, exist);
            exist.remove();
        });
    });
    

    // 다이얼 로그 생성 이벤트
    $(".link-login").on("click", e => {
        e.preventDefault();
        $("#nav-open")[0].checked = false;
        dialog.login.dialog("open");
    });

    $(".link-join").on("click", e => {
        e.preventDefault();
        $("#nav-open")[0].checked = false;
        dialog.join.dialog("open");
    });



    // 커스텀 파일 input
    $(".input-file > input").on("input", function(){
        let file = this.files.length > 0 && this.files[0];
        if(file) $(this).prev().text(file.name);
        else $(this).prev().text('');
    })
});