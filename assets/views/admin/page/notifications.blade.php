<style>
    .wp_cricket_scoring_notification__wrapper.bottom {
        position: fixed;
        bottom: 0;
        width: 80%;
        background: #f1f1f1;
        z-index: 999;
        padding: 1rem 2rem;
        left: 10%;
        border: 2px solid black;
    }

    .wp_cricket_scoring_notification__wrapper.fail {
        border-color: red;
    }

    .wp_cricket_scoring_notification__wrapper.success {
        border-color: green;
    }

</style>

<div class="wp_cricket_scoring_notification__wrapper {{ $notifications->position() }} {{ $notifications->status() }}">
    @foreach($notifications->notices() as $notice)
    <p class="wp_cricket_scoring_notification__notice">{!! $notice !!}</p>
    @endforeach
</div>
