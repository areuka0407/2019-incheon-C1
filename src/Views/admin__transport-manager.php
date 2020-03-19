<div class="admin-content">
    <div class="title">교통편 임대 관리</div>
    <table class="list">
        <thead>
            <tr>
                <th style="width: 500px">관련 정보</th>
                <th style="width: 150px">관리</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($transports as $transport):?>
            <tr>
                <td>
                    <div class="list__detail-row list__festival-name-row">
                        <div class="detail__title">교통편 이름</div>
                        <div class="detail__content"><?=$transport->name?></div>
                    </div>
                    <div class="list__detail-row list__venue-name">
                        <div class="detail__title">교통편 소개</div>
                        <div class="detail__content"><?=$transport->description?></div>
                    </div>
                    <div class="list__detail-row list__venue-name">
                        <div class="detail__title">운임</div>
                        <div class="detail__content">&#x20A9;<?=$transport->price?></div>
                    </div>
                </td>
                <td class="list__control">
                    <button class="list__control-delete-button button" onclick="confirm('정말로 삭제하시겠습니까?') && location.assign('/admin/delete-transportation/<?=$transport->id?>') ">삭제</button>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>