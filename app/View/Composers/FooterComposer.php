<?php

namespace App\View\Composers;

use App\Models\FooterLink;
use App\Models\FooterSetting;
use Illuminate\View\View;

class FooterComposer
{
    public function compose(View $view): void
    {
        $setting = FooterSetting::current();

        if (! $setting->is_active) {
            $view->with([
                'footerSetting' => null,
                'footerSocialLinks' => collect(),
            ]);

            return;
        }

        $view->with([
            'footerSetting' => $setting,
            'footerSocialLinks' => FooterLink::activeOrdered(FooterLink::GROUP_SOCIAL)->get(),
        ]);
    }
}
