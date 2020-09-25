document.addEventListener("DOMContentLoaded", function(event) {
  console.log("DOM fully loaded and parsed");
  var element = document.getElementById("demo");
  console.log(element);
  html2canvas(element).then(function(canvas) {
    var base64Image = canvas.toDataURL('image/jpeg', 1);
    // console.log(base64Image);
    let elem = document.createElement('a');
    elem.href = base64Image;
    elem.setAttribute('download', 'felicdades.jpg');
    document.body.appendChild(elem);
    elem.click();
  });
});
