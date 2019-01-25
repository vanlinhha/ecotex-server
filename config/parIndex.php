<?php

$arr_type_xhh = array(
    'KSCB'  => 'Khảo sát cán bộ',
    'SIPAS' => 'Khảo sát người dân (Sipas)',
);
/**
 * Chức danh người sử dụng
 */
return [
    'menu-left' =>
    [
        [
            'label'  => 'QUẢN TRỊ NỘI DUNG',
            'permit' => [
                'calculationFormula'  => [
                    'class_icon' => 'fa fa-calculator',
                    'label'      => 'Công thức tính'
                ],
                'form-question'       => [
                    'class_icon' => 'fa fa-question',
                    'label'      => 'Quản lý bộ câu hỏi CCHC'
                ],
                'sipas-form-question' => [
                    'class_icon' => 'fa fa-wpforms',
                    'label'      => 'Mẫu phiếu điều tra XHH'
                ],
                'evaluation-round'    => [
                    'class_icon' => 'fa fa-cubes',
                    'label'      => 'Quản lý đợt đánh giá'
                ],
                'assignment'          => [
                    'class_icon' => 'fa fa-sign-in',
                    'label'      => 'Phân công phòng ban đánh giá'
                ],
                'enter_answer'        => [
                    'class_icon' => 'fa fa-calendar',
                    'label'      => 'Nhập kết quả đánh giá'
                ],
                'sipas-evaluation-round'  => [
                    'class_icon' => 'fa fa-calendar-minus-o',
                    'label'      => 'Nhập KQ khảo sát XHH'
                ],
                'awaiting_approval'   => [
                    'class_icon' => 'fa fa-hourglass-2',
                    'label'      => 'Duyệt kết quả đánh giá'
                ],
                'assign'              => [
                    'class_icon' => 'fa fa-sign-in',
                    'label'      => 'Phân công cán bộ thẩm định'
                ],
                'expertise'           => [
                    'class_icon' => 'fa fa-legal',
                    'label'      => 'Thẩm định kết quả'
                ],
                'general_result'      => [
                    'class_icon' => 'fa fa-stack-overflow',
                    'label'      => 'Tổng hợp kết quả đánh giá'
                ],
                'publish_result'      => [
                    'class_icon' => 'fa fa-legal',
                    'label'      => 'Công bố kết quả'
                ],
                'search'              => [
                    'class_icon' => 'fa fa-search',
                    'label'      => 'Tra cứu'
                ],
                'notification'        => [
                    'class_icon' => 'fa fa-bell-o',
                    'label'      => 'Thông báo'
                ],
                'media' => [
                    'class_icon' => 'fa fa-file',
                    'label'      => 'Thư viện'
                ],
            ]
        ],
        [
            'label'  => 'QUẢN TRỊ HỆ THỐNG',
            'permit' => [
                'ou'    => [
                    'class_icon' => 'fa fa-home',
                    'label'      => 'Đơn vị - Phòng ban'
                ],
                'group' => [
                    'class_icon' => 'fa fa-group',
                    'label'      => 'Nhóm người sử dụng'
                ],
                'user'  => [
                    'class_icon' => 'fa fa-user',
                    'label'      => 'Người sử dụng'
                ],
            ]
        ],
        [
            'label'  => 'BÁO CÁO',
            'permit' => [
                'report1' => [
                    'class_icon' => 'fa fa-copy',
                    'label'      => 'Báo cáo tổng hơp'
                ],
                'report6' => [
                    'class_icon' => 'fa fa-copy',
                    'label'      => 'Báo cáo kết quả chỉ số CCHC'
                ],
                'report2' => [
                    'class_icon' => 'fa fa-copy',
                    'label'      => 'Báo cáo chi tiết từng đơn vị'
                ],
                'report3' => [
                    'class_icon' => 'fa fa-copy',
                    'label'      => 'Báo cáo tổng hợp lĩnh vực'
                ],
                'report4' => [
                    'class_icon' => 'fa fa-copy',
                    'label'      => 'Báo cáo chi tiết lĩnh vực'
                ],
                'report5' => [
                    'class_icon' => 'fa fa-copy',
                    'label'      => 'Báo cáo phân tích tiêu chí'
                ],
                'report_sipas1' => [
                    'class_icon' => 'fa fa-copy',
                    'label'      => 'Báo cáo tổng hợp SIPAS'
                ],
                'report_sipas2' => [
                    'class_icon' => 'fa fa-copy',
                    'label'      => 'Biểu đồ tổng hợp SIPAS'
                ],
                'report_sipas3' => [
                    'class_icon' => 'fa fa-copy',
                    'label'      => 'Báo cáo người trả lời SIPAS'
                ],
                'report_sipas4' => [
                    'class_icon' => 'fa fa-copy',
                    'label'      => 'Báo cáo chi tiết SIPAS'
                ],
            ]
        ]
    ],
    //Danh sách quyền xử lý trong hệ thống
    'roles'     => [
        [
            'label'  => 'Quản trị par index',
            'permit' => [
                [
                    'code'  => 'ou',
                    'label' => 'Quản trị đơn vị/phòng ban'
                ],
                [
                    'code'  => 'group',
                    'label' => 'Quản trị /Nhóm NSD'
                ],
                [
                    'code'  => 'user',
                    'label' => 'Quản trị NSD'
                ],
                [
                    'code'  => 'calculationFormula',
                    'label' => 'Công thức tính'
                ],
                [
                    'code'  => 'form-question',
                    'label' => 'Quản trị bộ câu hỏi CCHC'
                ],
                [
                    'code'  => 'sipas-form-question',
                    'label' => 'Mẫu phiếu điều tra XHH'
                ],
                [
                    'code'  => 'evaluation-round',
                    'label' => 'Quản trị đợt đánh giá'
                ],
                [
                    'code'  => 'assignment',
                    'label' => 'Phân công phòng ban đánh giá'
                ],
                [
                    'code'  => 'enter_answer',
                    'label' => 'Nhập kết quả đánh giá'
                ],
                [
                    'code'  => 'sipas-evaluation-round',
                    'label' => 'Nhập KQ khảo sát XHH'
                ],
                [
                    'code'  => 'awaiting_approval',
                    'label' => 'Duyệt kết quả đánh giá'
                ],
                [
                    'code'  => 'assign',
                    'label' => 'Phân công cá bộ thẩm định'
                ],
                [
                    'code'  => 'expertise',
                    'label' => 'Thẩm định kết quả đánh giá'
                ],
                [
                    'code'  => 'search',
                    'label' => 'Tra cứu'
                ],
                [
                    'code'  => 'general_result',
                    'label' => 'Tổng hợp quả đánh giá'
                ],
                [
                    'code'  => 'publish_result',
                    'label' => 'Ban hành kết quả đánh giá'
                ],
                [
                    'code'  => 'report1',
                    'label' => 'Báo cáo tổng hơp'
                ],
                [
                    'code'  => 'report6',
                    'label' => 'Báo cáo kết quả chỉ số CCHC'
                ],
                [
                    'code'  => 'report2',
                    'label' => 'Báo cáo chi tiết từng đơn vị'
                ],
                [
                    'code'  => 'report3',
                    'label' => 'Báo cáo tổng hợp lĩnh vực'
                ],
                [
                    'code'  => 'report4',
                    'label' => 'Báo cáo chi tiết lĩnh vực'
                ],
                [
                    'code'  => 'report5',
                    'label' => 'Báo cáo phân tích tiêu chí'
                ],
                [
                    'code'  => 'report_sipas1',
                    'label' => 'Báo cáo tổng hợp sipas'
                ],
                [
                    'code'  => 'report_sipas2',
                    'label' => 'Biểu đồ tổng hợp sipas'
                ],
                [
                    'code'  => 'report_sipas3',
                    'label' => 'Báo cáo người trả lời SIPAS'
                ],
                [
                    'code'  => 'report_sipas4',
                    'label' => 'Báo cáo chi tiết SIPAS'
                ],
            ]
        ]
    ],
    'type-xhh'  => $arr_type_xhh,
];
