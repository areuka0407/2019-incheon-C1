<script src="/js/transportation.js"></script>

<!-- VISUAL -->
 <div id="visual" class="sub-page">
    <div class="images">
        <div></div>
    </div>
    <div class="visual-contents">
        <div>
            <div class="text">
                <p>BEXCO > 교통편 예약</p> 
                <p class="fx-5 light" lang="en">Transportation <span class="fx-2 bold">Reservation</span></p>
            </div>
        </div>
    </div>
</div>
<!-- /VISUAL -->

<!-- RESERVE -->
<div id="reserve-transport">
    <div class="container padding px-2">
        <div>
            <p class="fx-3">교통편 예약 목록</p>
            <p class="mt-1 light">현재 예약이 가능한 교통편 목록입니다.</p>
        </div>
        <form action="#" method="post">
            <div class="transport-table mt-4 w-100">
                <div class="thead">
                    <div class="tdata checkbox">선택</div>
                    <div class="tdata info">교통편</div>
                    <div class="tdata price">운임 비용</div>
                    <div class="tdata rest">휴무일</div>
                    <div class="tdata interval">운행주기</div>
                    <div class="tdata cycle">운행시간</div>
                    <div class="tdata status">운행상태</div>
                </div>
                <div class="tbody">
                    <div class="titem position-relative">
                        <label for="t-checkbox-1" class="position-absolute w-100 h-100 left-0 top-0"></label>
                        <div class="tdata checkbox">
                            <input type="radio" id="t-checkbox-1" name="reserve-id" hidden>
                            <label for="t-checkbox-1" class="custom-checkbox"></label>
                        </div>
                        <div class="tdata info">
                            <div>
                                <span class="fx-1 bold text-black">고속 버스 1번</span>
                                <p class="mt-1 fx-n1">먼 이동기간동안 당신의 여행 파트너가 되어줄 고속 버스입니다</p>
                            </div>
                        </div>
                        <div class="tdata price">￦ 12,000</div>
                        <div class="tdata rest">일, 수, 토</div>
                        <div class="tdata interval">30분</div>
                        <div class="tdata cycle">06:00 ~ 22:00</div>
                        <div class="tdata status">
                            <div class="success">운행중</div>
                        </div>
                    </div>
                    <div class="titem disabled">
                        <div class="tdata checkbox">
                            <input type="checkbox" id="t-checkbox-5" hidden>
                            <label for="t-checkbox-5" class="custom-checkbox"></label>
                        </div>
                        <div class="tdata info">
                            <div>
                                <span class="fx-1 bold text-black">레드 버스</span>
                                <p class="mt-1 fx-n1">빠르게 이동하고 싶으신가요? 레드 버스를 이용해 주세요</p>
                            </div>
                        </div>
                        <div class="tdata price">￦ 15,000</div>
                        <div class="tdata rest">일</div>
                        <div class="tdata interval">15분</div>
                        <div class="tdata cycle">07:00 ~ 22:00</div>
                        <div class="tdata status">
                            <div class="error">
                                운행 중지
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /RESERVE -->

<!-- DIALOG - RESERVE TRANSPORT -->
<div id="dialog-reserve-transport">
    <div class="fx-4 text-center text-red bold mt-2 mb-4">
        교통편 예약
    </div>
    <form action="#" method="post" class="d-flex flex-wrap text-gray">
        <input type="hidden" id="transport_id" name="transport_id">
        <div class="left w-50 px-2">
            <div class="text-black mb-1">교통편 선택</div>
            <div class="py-1">
                <label class="fx-n1" for="reserve-transport">이동 수단</label>
                <input type="text" id="reserve-transport" class="form-control" value="고속 버스 1번" readonly>
            </div>
            <div class="py-1">
                <label class="fx-n1" for="reserve-date">이용 일자</label>
                <input type="text" id="reserve-date" class="form-control datetime" name="date" readonly>
            </div>
            <div class="py-1">
                <label class="fx-n1" for="reserve-time">이용 시간</label>
                <select id="reserve-time" class="form-control datetime" name="time">
                    <option value>일자를 먼저 선택하세요</option>
                </select>
            </div>
        </div>
        <div class="right w-50 px-2">
            <div class="text-black mb-1">
                <span>예매 개수</span>
                <small class="text-muted ml-1">* 남은 좌석: <span class="limit">0</span>개</small>
            </div>
            <div class="py-1">
                <label class="fx-n1 mb-1 d-inline-block" for="cnt-child">어린이</label>
                <input type="text" id="cnt-child" value="0" name="cnt_child">
            </div>
            <div class="py-1">
                <label class="fx-n1 mb-1 d-inline-block" for="cnt-adult">어른</label>
                <input type="text" id="cnt-adult" value="0" name="cnt_adult">
            </div>
            <div class="py-1">
                <label class="fx-n1 mb-1 d-inline-block" for="cnt-old">노약자</label>
                <input type="text" id="cnt-old" value="0" name="cnt_old">
            </div>
        </div>
        <div class="bottom w-100 mx-2 mt-3 mb-2 fx-n1 d-flex justify-content-between align-items-center">
            <div>
                <span class="fx-n1">총 가격</span>
                <span class="total-price ml-2 fx-3 text-red">￦ 0</span>
            </div>
            <button class="button">예약하기</button>
        </div>
    </form>
</div>
<!-- /DIALOG - RESERVE TRANSPORT -->
