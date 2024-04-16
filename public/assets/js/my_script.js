// Fungsi untuk memformat angka dengan titik sebagai pemisah ribuan
function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + "").replace(/[^0-9+\-Ee.]/g, "");
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
        dec = typeof dec_point === "undefined" ? "." : dec_point,
        s = "",
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return "" + (Math.round(n * k) / k).toFixed(prec);
        };
    s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || "").length < prec) {
        s[1] = s[1] || "";
        s[1] += new Array(prec - s[1].length + 1).join("0");
    }
    return s.join(dec);
}

function terbilang(number) {
    const huruf = [
        "",
        "Satu",
        "Dua",
        "Tiga",
        "Empat",
        "Lima",
        "Enam",
        "Tujuh",
        "Delapan",
        "Sembilan",
        "Sepuluh",
        "Sebelas",
    ];
    if (number < 12) return huruf[number];
    if (number < 20) return huruf[number - 10] + " Belas";
    if (number < 100)
        return huruf[Math.floor(number / 10)] + " Puluh " + huruf[number % 10];
    if (number < 200) return "Seratus " + terbilang(number % 100);
    if (number < 1000)
        return (
            huruf[Math.floor(number / 100)] +
            " Ratus " +
            terbilang(number % 100)
        );
    if (number < 2000) return "Seribu " + terbilang(number % 1000);
    if (number < 1000000)
        return (
            terbilang(Math.floor(number / 1000)) +
            " Ribu " +
            terbilang(number % 1000)
        );
    if (number < 1000000000)
        return (
            terbilang(Math.floor(number / 1000000)) +
            " Juta " +
            terbilang(number % 1000000)
        );
    return (
        terbilang(Math.floor(number / 1000000000)) +
        " Milyar " +
        terbilang(number % 1000000000)
    );
}
