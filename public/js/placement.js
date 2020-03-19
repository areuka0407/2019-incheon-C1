let app;

class App {
    get startDate(){
        return this.dialog.find("#start-date").val();
    }
    get endDate(){
        return this.dialog.find("#end-date").val();
    }

    constructor(){
        this.init();
    }

    async init(){
        this.placements = await this.getPlacements();
        this.reservations = await this.getReservation();
        console.log(this.reservations);

        this.placeId = null;

        this.pickerOption = {
            prevText: "이전 달",
            nextText: "다음 달",
            monthNames: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
            monthNamesShort: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
            dayNames: ["일", "월", "화", "수", "목", "금", "토"],
            dayNamesShort: ["일", "월", "화", "수", "목", "금", "토"],
            dayNamesMin: ["일", "월", "화", "수", "목", "금", "토"],
            yearSuffix: "년",
            showMonthAfterYear:true,
            dateFormat: "yy-mm-dd", 
            beforeShowDay: function(date){
                if(app.placeId === null) return [false];

                let placement = app.placements.find(place => place.id == app.placeId);
                let hasEvents = app.reservations.filter(evt => evt.placement == app.placeId);

                let overlap__rest = !placement.rest.includes( date.getDay() );


                let overlap__events = !hasEvents.reduce((prev, current) => {
                    let isOverlap = new Date(current.since).getTime() <= date && date <= new Date(current.until).getTime();
                    return prev || isOverlap;
                }, false)

                console.log(app.startDate, app.endDate);                
                let overlap__startDate = app.startDate.trim() !== "" && this.id !== "start-date" ? date >= new Date(new Date(app.startDate).parseString()).getTime() : true;
                let overlap__endDate = app.endDate.trim() !== "" && this.id !== "end-date" ? date <= new Date(new Date(app.endDate).parseString()).getTime() : true;
                
                let no_include_disabled = true;
                if(app.startDate.trim() !== "" && this.id == "end-date"){
                    let startDate = new Date(app.startDate);
                    let day = startDate.getDate() + 1; // 일
                    let in_overlap__rest, in_overlap__events;
                    let compareDate;
                    do {
                        compareDate = new Date(startDate.getFullYear(), startDate.getMonth(), day)
                        in_overlap__rest = !placement.rest.includes(compareDate.getDay());
                        in_overlap__events = !hasEvents.reduce((prev, current) => {
                            let isOverlap = new Date(current.since) <= compareDate && compareDate <= new Date(current.until);
                            return prev || isOverlap;
                        }, false)
                        day++;
                    } while(in_overlap__rest && in_overlap__events && day - startDate.getDate() < 10);
                    no_include_disabled = compareDate >= date;
                }
                else if(app.endDate.trim() !== "" && this.id == "start-date"){
                    let startDate = new Date(app.endDate);
                    let day = startDate.getDate() - 1; // 일
                    let in_overlap__rest, in_overlap__events;
                    let compareDate;
                    do {
                        compareDate = new Date(startDate.getFullYear(), startDate.getMonth(), day)
                        in_overlap__rest = !placement.rest.includes(compareDate.getDay());
                        in_overlap__events = !hasEvents.reduce((prev, current) => {
                            let isOverlap = new Date(current.since) <= compareDate && compareDate <= new Date(current.until);
                            return prev || isOverlap;
                        }, false)
                        day--;
                    } while(in_overlap__rest && in_overlap__events && day - startDate.getDate() < 10);
                    no_include_disabled = compareDate <= date;
                }

                return [overlap__events && overlap__rest && overlap__startDate && overlap__endDate && no_include_disabled];
            },
        };


        this.dialog = $("#dialog-reservation");
        this.dialog.dialog({
            autoOpen: false,
            resizable: false,
            width: 500,
            close: function(){
                $(this).find("#start-date").val('');
                $(this).find("#end-date").val('');
            }
        });

        this.setPlacement();
        this.setEvent();
    }

    setPlacement(){
        let dayList = "일월화수목금토".split("");

        let contains = document.querySelector("#reserve-placement .list");
        contains.innerHTML = '';
        this.placements.forEach(place => {
            let item = $(`<div class="item item-33 item-sm-100 hover-opacity-reverse pointer" data-id="${place.id}">
                            <div class="w-100 hx-250">
                                <img class="image-cover" src="/images/placement/${place.image}" alt="행사장 이미지">
                            </div>
                            <div class="pl-2 pr-2 py-2">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="text-black bold fx-2">${place.name}</span>
                                    <div class="score d-flex align-items-center">
                                        <img src="/images/scores/${place.score}.png" alt="${place.score}" height="20">
                                        <span class="fx-n2 text-red ml-1">${place.score}점</span>
                                    </div>
                                </div>
                                <p class="mt-2 text-muted fx-n2 d-flex flex-wrap">
                                    <span class="mr-2">임대료(1일): ${place.price.toLocaleString()} 만원</span>
                                    <span class="mr-2">${place.rest.map(d => dayList[d]).join(", ")}요일 휴무</span>
                                </p>
                                <p class="text-gray fx-n1 mt-1">
                                    ${place.description}
                                </p>
                            </div>
                        </div>`)[0];
            contains.append(item);
        });
    }

    setEvent(){
        this.dialog.find("form").on("submit", function(e){
            e.preventDefault();

            if(this.querySelector("#event-image").files.length === 0){
                alert("행사 이미지를 업로드해 주세요!");
                return;
            }

            e.target.submit();
        });

        $("#reserve-placement .list").on("click", ".item", async e => {
            let target = e.currentTarget || e.target;
            this.placeId = parseInt(target.dataset.id);
            $("#placement").val(this.placeId);
            
            let startDate = this.dialog.find("#start-date");
            let endDate = this.dialog.find("#end-date");
            startDate.datepicker(this.pickerOption);
            endDate.datepicker(this.pickerOption);

            startDate.on("input", e => {
                console.log(e.target.value);
            });
            endDate.on("input", e => {
                console.log(e.target.value);
            });
        
            this.dialog.dialog("open");
        });
    }

    // ajax

    getPlacements(){
        return new Promise(res => {
            Ajax.post("/ajax-list/placement")
            .then(list => {
                res(list.map(x => {
                    x.rest = JSON.parse(x.rest);
                    return x;
                }))
            });
        });
    }
    
    getReservation(){
        return Ajax.post("/ajax-list/reserve_placement");
    }
}

window.addEventListener("load", e => {
    app = new App();
});