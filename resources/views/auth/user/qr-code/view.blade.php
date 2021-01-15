<div class="row mt-3">
    <div class="col-12 text-center">
        @php
            $url = Request::root();
            $param ='/auto-time/tito?username='.Auth::user()->username.'&password='.Auth::user()->password;
        @endphp
        <img src="data:image/png;base64,{{DNS2D::getBarcodePNG($url.$param, 'QRCODE')}}" alt="barcode"/>
    </div>
</div>
<div class="row mt-3">
    <div class="col-12 text-center">
        <p class="text-dark">
            if you scan me you will be automatically time in or time out
        </p>
    </div>
</div>
<div class="row mt-2">
    <div class="col-12 text-center">
        <a href="/my-qr-code/download" target="_blank" class="btn btn-success rounded-0"> DOWNLOAD QR CODE </a>
    </div>
</div>
