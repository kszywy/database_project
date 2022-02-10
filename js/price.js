function priceCalc() {
  let priceValue = 650;
  let tmp = 50;
  const price = document.getElementById("price");
  price.innerText = priceValue.toFixed(2) + " zł";

  const cms = document.getElementById("cms");
  const gp = document.getElementById("gp");
  const seo = document.getElementById("seo");
  const express = document.getElementById("express");
  const num = document.getElementById("num");
  const warn = document.getElementById("warning");

  num.defaultValue = 1;

  num.addEventListener(
    "input",
    function () {
      priceValue -= tmp;
      let val = 50 * Math.abs(Number(num.value));
      tmp = val;
      priceValue += val;

      if (num.value != 0 && num.value <= 1000) {
        price.innerText = priceValue.toFixed(2) + " zł";
        warn.innerText = "";
        cms.disabled = false;
        gp.disabled = false;
        seo.disabled = false;
        express.disabled = false;
        price.style.borderColor = "#2ecc71";
      } else if (num.value == 0) {
        warn.innerText = "Projekt wymaga przynajmniej jednej strony";
        cms.disabled = true;
        gp.disabled = true;
        seo.disabled = true;
        express.disabled = true;
        price.style.borderColor = "red";
      }else{
        warn.innerText = "Maksymalna ilość stron to 1000.";
        price.innerText = "\n";
        cms.disabled = true;
        gp.disabled = true;
        seo.disabled = true;
        express.disabled = true;
        price.style.borderColor = "red";
      }
    },
    false
  );

  cms.addEventListener(
    "input",
    function () {
      if (cms.checked) {
        priceValue += 600;
        price.innerText = priceValue.toFixed(2) + " zł";
      } else {
        priceValue -= 600;
        price.innerText = priceValue.toFixed(2) + " zł";
      }
    },
    false
  );

  gp.addEventListener(
    "input",
    function () {
      if (gp.checked) {
        priceValue += 500;
        price.innerText = priceValue.toFixed(2) + " zł";
      } else {
        priceValue -= 500;
        price.innerText = priceValue.toFixed(2) + " zł";
      }
    },
    false
  );

  seo.addEventListener(
    "input",
    function () {
      if (seo.checked) {
        priceValue += 600;
        price.innerText = priceValue.toFixed(2) + " zł";
      } else {
        priceValue -= 600;
        price.innerText = priceValue.toFixed(2) + " zł";
      }
    },
    false
  );

  express.addEventListener(
    "input",
    function () {
      if (express.checked) {
        finalValue = priceValue * 1.2;
        price.innerText = finalValue.toFixed(2) + " zł";
        cms.disabled = true;
        gp.disabled = true;
        seo.disabled = true;
        num.disabled = true;
      } else {
        price.innerText = priceValue.toFixed(2) + " zł";
        cms.disabled = false;
        gp.disabled = false;
        seo.disabled = false;
        num.disabled = false;
      }
    },
    false
  );
}

priceCalc();

document.getElementById("logout").addEventListener(
  "click",
  function () {
    window.location.assign("../main/login.php");
  },
  false
);


document.getElementById("hiddenReset").click();
