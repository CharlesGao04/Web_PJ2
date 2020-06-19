var fileD = document.getElementById("uploadImg");

function judgeSrc() {
    var file=fileDom.files[0];
    return file.name;
}

alert(judgeSrc());