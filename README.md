## Kodel filepond?

Is pradziu tai buvo jokios priezastis. Tiesiog tu paminejai, filament naudoja tai ir vaziuojam.

Dabar paziurejau kitas alternatyvas kelias, tai po kelis metus jokio aktyvumo. Filepond laiks nuo laiko patagina nauja versija.

Plius prisiminiau sita posta rasyta: https://laraveldaily.com/post/laravel-filepond-guide

---

## Install Filepond

Kaip ji instaliuoti tai visiskai _personal preference_. Kas naudos CDN, kas npm install. As pasirinkau si karta npm varianta: https://github.com/krekas/laravel-chunk-uploads/commit/87171100ece95ede9e9d8153198db0b6b5e660de

I `resources/js/app.js` importavau, ir padariau, kad butu jis globaliai.

`dashboard.blade.php` inicijuojamas filepond, esme yra config jog zinotu filepond, kad chunks naudojam. `chunkSize` kiekvienas pagal save pasizaisti gali. Toliau server url ir header is musu posto paimta.

## Server Config

NIEKO NEREIKIA. Tam ir yra chunks, kad siuncia faila tokiu dydziu kokiu nustatai ir galima naudoti tiesiog default visus max upload size (google sako 2mb, netikrinau).

---

## Variantas Be Package

Kodas is esmes su AI, bet su nemazai try and error. Visu pirma, ka daro filepond: pirma siuncia **post** request, o visi sekantys eina jau **patch**. Todel route ir yra du tipai:
https://github.com/krekas/laravel-chunk-uploads/blob/no-package-chunk-upload/routes/web.php#L19
```php
Route::match(['post', 'patch'], 'upload', UploadController::class)->name('upload');
```

Tuomet filepond siuncia ir custom headerius: https://pqina.nl/filepond/docs/api/server/#process-chunks

Jeigu failas mazesnis negu chunk tai siuncia paprastai, todel ir yra du upload variantai. Tas regular file upload tai realiai dzin, nieko ten isskirtinio.

Ziurim tik chunk upload logika.

https://github.com/krekas/laravel-chunk-uploads/blob/no-package-chunk-upload/app/Services/ChunkUploadService.php

Is headeriu turim info apie faila. Tada temp direktorija kur failo chunks keliami. Kai viskas sukelta, paskutinio chunk dydis bus mazesnis negu kitu, tuomet jau judama toliau.

Surenkam visus chunks i galutini faila, padedam i reikiama vieta, isvalom temp direktorija, sukuriam db irasa.

---

## Variantas Su Package

Cia tiesiog alternatyva, kad yra ir package.

[Quickstart](https://github.com/rahulhaque/laravel-filepond?tab=readme-ov-file#quickstart) ta pati raso, filepond instalini, kaip nori. Esme tik nurodyti teisinga server URL.

Package esme, kad, handlina visa upload. Paskui tik perkelti belieka is temp vietos i teisinga. Sito perkelimo nepadariau, quickstart yra pamineta kaip ta padaryti:
```php
// Set filename
$avatarName = 'avatar-' . auth()->id();

// Move the file to permanent storage
// Automatic file extension set
$fileInfo = Filepond::field($request->avatar)
    ->moveTo('avatars/' . $avatarName);
```
