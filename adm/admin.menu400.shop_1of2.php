<?php
if (!defined('G5_USE_SHOP') || !G5_USE_SHOP) return;

$menu['menu400'] = array (
    array('400000', '쇼핑몰관리', G5_ADMIN_URL.'/shop_admin/', 'shop_config'),
    array('400100', '쇼핑몰설정', G5_ADMIN_URL.'/shop_admin/configform.php', 'scf_config'),
    array('400400', '주문내역', G5_ADMIN_URL.'/shop_admin/orderlist.php', 'scf_order', 1),
    //array('400440', '개인결제관리', G5_ADMIN_URL.'/shop_admin/personalpaylist.php', 'scf_personalpay', 1),
    array('400200', '분류관리', G5_ADMIN_URL.'/shop_admin/categorylist.php', 'scf_cate'),
    array('400300', '상품관리', G5_ADMIN_URL.'/shop_admin/itemlist.php', 'scf_item'),
    array('400660', '응원메시지', G5_ADMIN_URL.'/shop_admin/itemqalist.php', 'scf_item_qna'),
    array('400650', '리뷰', G5_ADMIN_URL.'/shop_admin/itemuselist.php', 'scf_ps'),
    //array('400620', '상품재고관리', G5_ADMIN_URL.'/shop_admin/itemstocklist.php', 'scf_item_stock'),
    array('400610', '상품유형관리', G5_ADMIN_URL.'/shop_admin/itemtypelist.php', 'scf_item_type'),
	array('400630', 'BESTVOICE', G5_ADMIN_URL.'/shop_admin/itemtypelist2.php', 'scf_item_type2'),
    //array('400500', '상품옵션재고관리', G5_ADMIN_URL.'/shop_admin/optionstocklist.php', 'scf_item_option'),
    //array('400800', '쿠폰관리', G5_ADMIN_URL.'/shop_admin/couponlist.php', 'scf_coupon'),
    //array('400810', '쿠폰존관리', G5_ADMIN_URL.'/shop_admin/couponzonelist.php', 'scf_coupon_zone'),
    //array('400750', '추가배송비관리', G5_ADMIN_URL.'/shop_admin/sendcostlist.php', 'scf_sendcost', 1),
    array('400410', '미완료주문', G5_ADMIN_URL.'/shop_admin/inorderlist.php', 'scf_inorder', 1),
);
?>