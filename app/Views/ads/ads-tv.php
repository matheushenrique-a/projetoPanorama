  <header class="py-3 mb-3 border-bottom">
    <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">

      <div class="d-flex align-items-center">
        <form class="w-100 me-3" role="search">
          <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
        </form>
      </div>
    </div>
  </header>

  <div class="container-fluid pb-3">
    <div class="d-grid gap-3">
      <div class="bg-body-tertiary border rounded-3">
        
        <?php
        
        $c = curl_init('https://www.facebook.com/ads/archive/render_ad/?id=2569448993219404&access_token=EAAMqjXZAxYiUBO1TS7ZACcUiPtuUO7ehiZAzWNl6P72emh5ohWqSyot3x7AP6ef1uLExt6ssCPe6eInRYinrTAexuqhUjsk2IJxeUnP8jgbNM3jBS6GCHoKAY8n8qD9K3xs5QAVEgeQR4WKGI7VfwYumZAZB3ZACmeHVQG0fMatwoihZBABp3dDTRCZC');
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        $html = curl_exec($c);

        if (curl_error($c)){
          die(curl_error($c));
        }
            
        $status = curl_getinfo($c, CURLINFO_HTTP_CODE);
        curl_close($c);
          
        echo $html;exit;
        
        ;?>
          
        </iframe>
      </div>
    </div>
  </div>
</main>