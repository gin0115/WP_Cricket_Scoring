<?php 
use \Gin0115\WP_Cricket_Scoring\Plugin_Settings\Settings_Keys as Keys;
?>

@form(method="post")
{!! $nonce !!}
@input(type="hidden" name="action" value="submit")
<div id="settings-form">
    @include(
        'admin.form.input-number', 
        [ 'key'=> Keys::LIVE_SCORE_POLL_INTERVAL
        , 'id' => Keys::LIVE_SCORE_POLL_INTERVAL
        , 'value' => $live_score_poll_interval
        , 'label' => "Live Score Update Interval"
        , 'icon' => 'clock'
        ]
    )
</div>
@button(type="submit" text="$i18n->settings_page_form_labels('form_submit_button')" class="button")
@endform()
