<?php

return [
    'importers' => [
        'customers' => [
            'title' => 'Khách hàng',

            'validation' => [
                'errors' => [
                    'duplicate-email'        => 'Email: \'%s\' được tìm thấy nhiều hơn một lần trong file nhập.',
                    'duplicate-phone'        => 'Số điện thoại: \'%s\' được tìm thấy nhiều hơn một lần trong file nhập.',
                    'email-not-found'        => 'Email: \'%s\' không tìm thấy trong hệ thống.',
                    'invalid-customer-group' => 'Nhóm khách hàng không hợp lệ hoặc không được hỗ trợ',
                ],
            ],
        ],

        'products' => [
            'title' => 'Sản phẩm',

            'validation' => [
                'errors' => [
                    'duplicate-url-key'         => 'URL key: \'%s\' đã được tạo cho một mục với SKU: \'%s\'.',
                    'invalid-attribute-family'  => 'Giá trị không hợp lệ cho cột nhóm thuộc tính (nhóm thuộc tính không tồn tại?)',
                    'invalid-type'              => 'Loại sản phẩm không hợp lệ hoặc không được hỗ trợ',
                    'sku-not-found'             => 'Sản phẩm với SKU đã chỉ định không tìm thấy',
                    'super-attribute-not-found' => 'Siêu thuộc tính với mã: \'%s\' không tìm thấy hoặc không thuộc về nhóm thuộc tính: \'%s\'',
                ],
            ],
        ],

        'tax-rates' => [
            'title' => 'Thuế suất',

            'validation' => [
                'errors' => [
                    'duplicate-identifier' => 'Định danh: \'%s\' được tìm thấy nhiều hơn một lần trong file nhập.',
                    'identifier-not-found' => 'Định danh: \'%s\' không tìm thấy trong hệ thống.',
                ],
            ],
        ],
    ],

    'validation' => [
        'errors' => [
            'column-empty-headers' => 'Cột số "%s" có tiêu đề trống.',
            'column-name-invalid'  => 'Tên cột không hợp lệ: "%s".',
            'column-not-found'     => 'Các cột yêu cầu không tìm thấy: %s.',
            'column-numbers'       => 'Số lượng cột không tương ứng với số lượng hàng trong tiêu đề.',
            'invalid-attribute'    => 'Tiêu đề chứa (các) thuộc tính không hợp lệ: "%s".',
            'system'               => 'Đã xảy ra lỗi hệ thống không mong muốn.',
        ],
    ],
];
