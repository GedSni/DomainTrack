<div class='overlay'>
    <div class='section1 layout'>
        <div class="container">
            <div class="row">
                <div>
                    <img style="float: right" id='topStatus' alt='Status' height='20px' width='20px'  src={{ asset('img/exclamation.png') }}>
                </div>
                <div class="col-4">
                    <a id='topName' rel='noreferrer noopener nofollow'></a>
                </div>
                <div class="col-2">
                    <p id='topRank'></p>
                </div>
                <div class="col-2">
                    <span id='topDiff' class='badge badge-pill'></span>
                </div>
                <div class="col">
                    <button class='btn btn-outline-primary exit' href='#'>Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class='section2'>
        <div id='loader'></div>
        <iframe id='mainFrame' frameborder='0' sandbox='allow-same-origin allow-scripts allow-popups allow-forms'
                src='' onerror="error('Failed to load');">
        </iframe>
    </div>
    <div class='section3 layout'>
        <div class="container">
            <div class="row justify-content-end">
                <div>
                    <img style="float: right" id='bottomStatus' alt='Status' height='20px' width='20px'  src={{ asset('img/exclamation.png') }}>
                </div>
                <div class="col-4">
                    <a id='bottomName' rel='noreferrer noopener nofollow'></a>
                </div>
                <div class="col-6">
                    <button class='btn btn-outline-primary nextRow'>Next</button>
                </div>
            </div>
        </div>
    </div>
</div>