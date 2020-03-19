<div class="admin-content">
    <div class="title">교통편 임대 관리</div>
    <table class="list">
        <thead>
            <tr>
                <th style="width: 500px">정보</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($reserveList as $res):?>
            <?php $res->member = json_decode($res->member);?>
            <tr>
                <td>
                    <div class="list__detail-row list__festival-name-row">
                        <div class="detail__title">교통편 이름</div>
                        <div class="detail__content"><?=$res->transport_name?></div>
                    </div>
                    <div class="list__detail-row list__venue-name">
                        <div class="detail__title">예약자 아이디</div>
                        <div class="detail__content"><?=$res->user_id?></div>
                    </div>
                    <div class="list__detail-row list__venue-name">
                        <div class="detail__title">지불 운임</div>
                        <div class="detail__content">&#x20A9;<?=number_format($res->price)?></div>
                    </div>
                    <div class="list__detail-row list__venue-name">
                        <div class="detail__title">탑승자 유형</div>
                        <div class="detail__content">어른: <?=$res->member->adult?>, 아이: <?=$res->member->kids?>, 경로자: <?=$res->member->old?></div>
                    </div>
                    <div class="list__detail-row list__venue-name">
                        <div class="detail__title">탑승일 / 예약일자</div>
                        <div class="detail__content"><?=$res->date?> / <?=$res->created_at?></div>
                    </div>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>