<div class="admin-content">
    <div class="title">행사장 임대 관리</div>
    <table class="list">
        <thead>
            <tr>
                <th style="width: 150px">대표 이미지</th>
                <th style="width: 500px">관련 정보</th>
                <th style="width: 150px">예약자</th>
                <th style="width: 150px">예약일자</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($reserveList as $res): ?>
            <tr>
                <td class="list__thumbnail-container">
                    <img src="/images/placement/<?=$res->image?>" alt="list__thumbnail" class="list__thumbnail">
                </td>
                <td>
                    <div class="list__detail-row list__festival-name-row">
                        <div class="detail__title">개최 행사 이름</div>
                        <div class="detail__content"><?=$res->name?></div>
                    </div>
                    <div class="list__detail-row list__venue-name">
                        <div class="detail__title">임대한 행사장 이름</div>
                        <div class="detail__content"><?=$res->place_name?></div>
                    </div>
                    <div class="list__detail-row list__festival-date">
                        <div class="detail__title">개최 기간</div>
                        <div class="detail__content"><?=$res->since?> ~ <?=$res->until?></div>
                    </div>
                </td>
                <td class="list__user">예약자 이름 (예약자 아이디)</td>
                <td class="list__created-at"><?=$res->created_at?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>