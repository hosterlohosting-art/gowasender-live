<div id="gowasender-preloader"
    style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: #0c1317; z-index: 99999; display: flex; flex-direction: column; justify-content: center; align-items: center; transition: opacity 0.5s ease-out;">
    <div style="text-align: center;">
        <img src="{{ asset('assets/img/brand/white.png') }}" alt="Loading..."
            style="height: 80px; width: auto; margin-bottom: 20px; animation: pulse 2s infinite;">
        <h4
            style="color: #ffffff; font-family: 'Inter', sans-serif; font-weight: 300; letter-spacing: 1px; margin-top: 10px;">
            Automation is loading...</h4>
        <div class="spinner-border text-success" role="status"
            style="width: 3rem; height: 3rem; margin-top: 20px; border-width: 3px;">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>

<style>
    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.05);
            opacity: 0.8;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
</style>

<script>
    window.addEventListener('load', function () {
        const preloader = document.getElementById('gowasender-preloader');
        if (preloader) {
            setTimeout(function () {
                preloader.style.opacity = '0';
                setTimeout(function () {
                    preloader.style.display = 'none';
                }, 500);
            }, 800); // Small delay to let user see the branding
        }
    });
</script>