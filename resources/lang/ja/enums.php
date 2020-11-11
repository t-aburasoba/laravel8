<?php
// resources/lang/ja/enums.php
use App\Enums\StoryType;
use App\Enums\SocialType;

return [
    StoryType::class => [
        StoryType::REASON => 'サービス制作した理由',
        StoryType::EFFORT => '実装の際に工夫した点',
        StoryType::ENHANCEMENT => '今後のサービスの展望',
    ],
    SocialType::class => [
        SocialType::GITHUB => 'GitHub',
        SocialType::TWITTER =>'Twitter',
        SocialType::WANTEDLY => 'Wantedly',
    ],
];
