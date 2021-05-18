/* Fungsi formatRupiah */
function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        angka = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? "." : "";
        angka += separator + ribuan.join(".");
    }

    angka = split[1] != undefined ? angka + "," + split[1] : angka;
    return prefix == undefined ? angka : angka ? angka : "";
}

//prevent for resubmit form
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
