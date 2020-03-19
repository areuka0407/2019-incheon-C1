<div class="admin-content">
    <div class="title">행사장 임대 관리</div>
    <table class="list">
        <thead>
            <tr>
                <th style="width: 150px">대표 이미지</th>
                <th style="width: 500px">관련 정보</th>
                <th style="width: 150px">관리</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($placements as $placement): ?>
            <tr>
                <td class="list__thumbnail-container">
                    <img src="/images/placement/<?=$placement->image?>" alt="list__thumbnail" class="list__thumbnail">
                </td>
                <td>
                    <div class="list__detail-row list__festival-name-row">
                        <div class="detail__title">행사장 이름</div>
                        <div class="detail__content"><?=$placement->name?></div>
                    </div>
                    <div class="list__detail-row list__venue-name">
                        <div class="detail__title">행사장 소개</div>
                        <div class="detail__content"><?=$placement->description?></div>
                    </div>
                    <div class="list__detail-row list__venue-name">
                        <div class="detail__title">임대료</div>
                        <div class="detail__content">&#x20A9;<?=number_format($placement->price)?></div>
                    </div>
                </td>
                <td class="list__control">
                    <button class="list__control-delete-button button" onclick="confirm('정말로 삭제하시겠습니까?') && location.assign('/admin/delete-placement/<?=$placement->id?>') ">삭제</button>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>