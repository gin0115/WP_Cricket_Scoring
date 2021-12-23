@form(method="post")
    {!! $nonce !!}
    <div id="settings-form">
        <div class="settings-grid__row">
            <div class="settings-grid__label">
                @label(for="live_score_poll_interval" text="Live Score Update Interval")
            </div>
            <div class="settings-grid__field">
                @input(type="text" name="live_score_poll_interval" value="$live_score_poll_interval")
            </div>
        </div>
    </div>
    @button(type="submit" text="$i18n->settings_page_form_labels('form_submit_button')" class="button")
@endform()
