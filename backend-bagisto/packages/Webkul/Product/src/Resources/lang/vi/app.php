<?php

return [
    'checkout' => [
        'cart' => [
            'integrity' => [
                'qty-missing'   => 'Ít nhất một sản phẩm phải có số lượng nhiều hơn 1.',
            ],

            'invalid-file-extension'   => 'Phần mở rộng tệp không hợp lệ.',
            'inventory-warning'        => 'Số lượng yêu cầu không có sẵn, vui lòng thử lại sau.',
            'missing-links'            => 'Liên kết tải xuống bị thiếu cho sản phẩm này.',
            'missing-options'          => 'Tùy chọn bị thiếu cho sản phẩm này.',
            'selected-products-simple' => 'Các sản phẩm được chọn phải là loại sản phẩm đơn giản.',
        ],
    ],

    'datagrid' => [
        'copy-of-slug'                  => 'ban-sao-cua-:value',
        'copy-of'                       => 'Bản sao của :value',
        'variant-already-exist-message' => 'Biến thể với các tùy chọn thuộc tính tương tự đã tồn tại.',
    ],

    'response' => [
        'product-can-not-be-copied' => 'Sản phẩm loại :type không thể được sao chép',
    ],

    'sort-by'  => [
        'options' => [
            'cheapest-first'  => 'Rẻ nhất trước',
            'expensive-first' => 'Đắt nhất trước',
            'from-a-z'        => 'Từ A-Z',
            'from-z-a'        => 'Từ Z-A',
            'latest-first'    => 'Mới nhất trước',
            'oldest-first'    => 'Cũ nhất trước',
        ],
    ],

    'type'     => [
        'abstract'     => [
            'offers' => 'Mua :qty với giá :price mỗi sản phẩm và tiết kiệm :discount',
        ],

        'bundle'       => 'Gói',
        'booking'      => 'Đặt chỗ',
        'configurable' => 'Có thể cấu hình',
        'downloadable' => 'Có thể tải xuống',
        'grouped'      => 'Nhóm',
        'simple'       => 'Đơn giản',
        'virtual'      => 'Ảo',
    ],
];
