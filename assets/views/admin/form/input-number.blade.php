<div class="settings-grid__row input input_number {{ $key }}">        
    <div class="settings-grid__label @isset($icon)icon @endisset()">
        @isset($icon)<span class="dashicons dashicons-{{ $icon }}"></span> @endisset()
        @label(for="$key" text="$label")
    </div>    
    <div class="settings-grid__field">
        @input(type="number" name="$key" id="$id" value="$value")
    </div>
</div>