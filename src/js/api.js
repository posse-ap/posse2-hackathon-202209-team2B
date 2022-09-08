const params = window.location.search;  //=> "?code=4f7b17572bee8cac9587"
const code = params.startsWith('?code=') ? params.split('=')[1] : undefined;
if (code) {
    alert('一時コード: ' + code);  //=> "4f7b17572bee8cac9587"
}

