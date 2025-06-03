<?php

return [
    'seeders' => [
        'attribute' => [
            'attribute-families' => [
                'default' => 'Mặc định',
            ],

            'attribute-groups' => [
                'description'       => 'Mô tả',
                'general'           => 'Tổng quan',
                'inventories'       => 'Kho hàng',
                'meta-description'  => 'Meta mô tả',
                'price'             => 'Giá',
                'settings'          => 'Cài đặt',
                'shipping'          => 'Vận chuyển',
            ],

            'attributes' => [
                'brand'                => 'Thương hiệu',
                'color'                => 'Màu sắc',
                'cost'                 => 'Chi phí',
                'description'          => 'Mô tả',
                'featured'             => 'Nổi bật',
                'guest-checkout'       => 'Thanh toán khách',
                'height'               => 'Chiều cao',
                'length'               => 'Chiều dài',
                'manage-stock'         => 'Quản lý kho',
                'meta-description'     => 'Meta mô tả',
                'meta-keywords'        => 'Meta từ khóa',
                'meta-title'           => 'Meta tiêu đề',
                'name'                 => 'Tên',
                'new'                  => 'Mới',
                'price'                => 'Giá',
                'product-number'       => 'Mã sản phẩm',
                'short-description'    => 'Mô tả ngắn',
                'size'                 => 'Kích thước',
                'sku'                  => 'SKU',
                'special-price'        => 'Giá đặc biệt',
                'special-price-from'   => 'Giá đặc biệt từ',
                'special-price-to'     => 'Giá đặc biệt đến',
                'status'               => 'Trạng thái',
                'tax-category'         => 'Danh mục thuế',
                'url-key'              => 'Khóa URL',
                'visible-individually' => 'Hiển thị riêng lẻ',
                'weight'               => 'Trọng lượng',
                'width'                => 'Chiều rộng',
            ],

            'attribute-options' => [
                'black'  => 'Đen',
                'green'  => 'Xanh lá',
                'l'      => 'L',
                'm'      => 'M',
                'red'    => 'Đỏ',
                's'      => 'S',
                'white'  => 'Trắng',
                'xl'     => 'XL',
                'yellow' => 'Vàng',
            ],
        ],

        'category' => [
            'categories' => [
                'description' => 'Mô tả danh mục gốc',
                'name'        => 'Gốc',
            ],
        ],

        'cms' => [
            'pages' => [
                'about-us' => [
                    'content' => 'Nội dung trang Về chúng tôi',
                    'title'   => 'Về chúng tôi',
                ],

                'contact-us' => [
                    'content' => 'Nội dung trang Liên hệ',
                    'title'   => 'Liên hệ',
                ],

                'customer-service' => [
                    'content' => 'Nội dung trang Dịch vụ khách hàng',
                    'title'   => 'Dịch vụ khách hàng',
                ],

                'payment-policy' => [
                    'content' => 'Nội dung trang Chính sách thanh toán',
                    'title'   => 'Chính sách thanh toán',
                ],

                'privacy-policy' => [
                    'content' => 'Nội dung trang Chính sách bảo mật',
                    'title'   => 'Chính sách bảo mật',
                ],

                'refund-policy' => [
                    'content' => 'Nội dung trang Chính sách hoàn tiền',
                    'title'   => 'Chính sách hoàn tiền',
                ],

                'return-policy' => [
                    'content' => 'Nội dung trang Chính sách đổi trả',
                    'title'   => 'Chính sách đổi trả',
                ],

                'shipping-policy' => [
                    'content' => 'Nội dung trang Chính sách vận chuyển',
                    'title'   => 'Chính sách vận chuyển',
                ],

                'terms-conditions' => [
                    'content' => 'Nội dung trang Điều khoản & Điều kiện',
                    'title'   => 'Điều khoản & Điều kiện',
                ],

                'terms-of-use' => [
                    'content' => 'Nội dung trang Điều khoản sử dụng',
                    'title'   => 'Điều khoản sử dụng',
                ],

                'whats-new' => [
                    'content' => 'Nội dung trang Có gì mới',
                    'title'   => 'Có gì mới',
                ],
            ],
        ],

        'core' => [
            'channels' => [
                'name'             => 'Mặc định',
                'meta-title'       => 'Cửa hàng demo',
                'meta-keywords'    => 'Từ khóa meta cửa hàng demo',
                'meta-description' => 'Mô tả meta cửa hàng demo',
            ],

            'currencies' => [
                'AED' => 'Dirham Các Tiểu Vương quốc Ả Rập Thống nhất',
                'ARS' => 'Peso Argentina',
                'AUD' => 'Đô la Úc',
                'BDT' => 'Taka Bangladesh',
                'BHD' => 'Dinar Bahrain',
                'BRL' => 'Real Brazil',
                'CAD' => 'Đô la Canada',
                'CHF' => 'Franc Thụy Sĩ',
                'CLP' => 'Peso Chile',
                'CNY' => 'Nhân dân tệ Trung Quốc',
                'COP' => 'Peso Colombia',
                'CZK' => 'Koruna Czech',
                'DKK' => 'Krone Đan Mạch',
                'DZD' => 'Dinar Algeria',
                'EGP' => 'Bảng Ai Cập',
                'EUR' => 'Euro',
                'FJD' => 'Đô la Fiji',
                'GBP' => 'Bảng Anh',
                'HKD' => 'Đô la Hồng Kông',
                'HUF' => 'Forint Hungary',
                'IDR' => 'Rupiah Indonesia',
                'ILS' => 'Shekel Israel mới',
                'INR' => 'Rupee Ấn Độ',
                'JOD' => 'Dinar Jordan',
                'JPY' => 'Yên Nhật',
                'KRW' => 'Won Hàn Quốc',
                'KWD' => 'Dinar Kuwait',
                'KZT' => 'Tenge Kazakhstan',
                'LBP' => 'Bảng Lebanon',
                'LKR' => 'Rupee Sri Lanka',
                'LYD' => 'Dinar Libya',
                'MAD' => 'Dirham Morocco',
                'MUR' => 'Rupee Mauritius',
                'MXN' => 'Peso Mexico',
                'MYR' => 'Ringgit Malaysia',
                'NGN' => 'Naira Nigeria',
                'NOK' => 'Krone Na Uy',
                'NPR' => 'Rupee Nepal',
                'NZD' => 'Đô la New Zealand',
                'OMR' => 'Rial Oman',
                'PAB' => 'Balboa Panama',
                'PEN' => 'Sol Peru',
                'PHP' => 'Peso Philippines',
                'PKR' => 'Rupee Pakistan',
                'PLN' => 'Zloty Ba Lan',
                'PYG' => 'Guarani Paraguay',
                'QAR' => 'Rial Qatar',
                'RON' => 'Leu Romania',
                'RUB' => 'Rúp Nga',
                'SAR' => 'Riyal Ả Rập Saudi',
                'SEK' => 'Krona Thụy Điển',
                'SGD' => 'Đô la Singapore',
                'THB' => 'Baht Thái',
                'TND' => 'Dinar Tunisia',
                'TRY' => 'Lira Thổ Nhĩ Kỳ',
                'TWD' => 'Đô la Đài Loan mới',
                'UAH' => 'Hryvnia Ukraine',
                'USD' => 'Đô la Mỹ',
                'UZS' => 'Som Uzbekistan',
                'VEF' => 'Bolívar Venezuela',
                'VND' => 'Đồng Việt Nam',
                'XAF' => 'Franc CFA BEAC',
                'XOF' => 'Franc CFA BCEAO',
                'ZAR' => 'Rand Nam Phi',
            ],
        ],
    ],

    'installer' => [
        'index' => [
            'environment-configuration' => 'Cấu hình môi trường',
            'extension-requirements'    => 'Yêu cầu mở rộng',
            'locale'                    => 'Ngôn ngữ',
            'license-agreement'         => 'Thỏa thuận giấy phép',
            'permission-requirements'   => 'Yêu cầu quyền',
            'pre-installation'          => 'Chuẩn bị cài đặt',
            'start'                     => 'Bắt đầu cài đặt',
            'title'                     => 'Cài đặt Bagisto',
        ],
    ],
];
