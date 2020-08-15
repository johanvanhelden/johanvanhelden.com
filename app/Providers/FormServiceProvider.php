<?php

declare(strict_types=1);

namespace App\Providers;

use Form;
use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $defaultComponents = [
            'email',
            'text',
            'textarea',
        ];

        foreach ($defaultComponents as $component) {
            Form::component('ui' . ucfirst($component), 'components.form.' . $component, [
                'name'       => null,
                'value'      => null,
                'label'      => null,
                'attributes' => [],
                'required'   => null,
                'text'       => null,
            ]);
        }

        Form::component('uiPassword', 'components.form.password', [
            'name'       => null,
            'label'      => null,
            'attributes' => [],
            'required'   => null,
            'text'       => null,
        ]);

        Form::component('uiCheckbox', 'components.form.checkbox', [
            'name'       => null,
            'value'      => null,
            'label'      => null,
            'attributes' => [],
            'text'       => null,
        ]);

        Form::component('uiCaptcha', 'components.form.captcha', [
            'text' => null,
        ]);
    }
}
