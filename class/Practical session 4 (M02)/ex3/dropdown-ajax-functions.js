function chonTinh(matinh) {
    const selectHuyen = document.forms["f_profile"].elements["s_huyen"];

    if (!matinh) {
        refreshHuyenJSON(selectHuyen, "[]");
        return;
    }

    const xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            refreshHuyenJSON(selectHuyen, xmlhttp.responseText);
        }
    };

    xmlhttp.open("GET", "get-huyen-JSON.php?matinh=" + encodeURIComponent(matinh), true);
    xmlhttp.send();
}

function refreshHuyenJSON(selectHuyen, data) {
    while (selectHuyen.options.length > 0) {
        selectHuyen.remove(0);
    }

    const defaultOption = document.createElement("option");
    defaultOption.value = "";
    defaultOption.text = "-- Chọn huyện --";
    selectHuyen.add(defaultOption);

    data = JSON.parse(data);

    for (let i = 0; i < data.length; i++) {
        const huyen = document.createElement("option");
        huyen.value = data[i].mahuyen;
        huyen.text = data[i].tenhuyen;
        selectHuyen.add(huyen);
    }
}