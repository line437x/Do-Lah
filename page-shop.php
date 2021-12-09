<?php

get_header(); ?>

<style>
	/* RYK ALLE STYLES OVER I CUSTOM.CSS */
img {
  display: block;
  width: 100%;
  height: auto;
  padding: 0;
  border: solid 1px black;
}
/* style på grid-produktoversigt i mobile */
#produktoversigt_container {
      display: grid;
      grid-template-columns: 1fr 1fr;
    }

#produktoversigt{
	grid-column: 1/3;
	display: grid;
	grid-template-columns: 1fr 1fr;
	}

#alle_knap {
      grid-column: 1/3;
    }

/* Style på produkt-boks i oversigt */
.produkt_information {
  position: absolute;
}
.produkt_navn,
.produkt_pris {
  color: black;
}
</style>


<div id="produktoversigt_container">
        <button id="alle_knap" class="filterknapper">Alle</button>
        <button class="filterknapper">Hår</button>
        <button class="filterknapper">Krop & hænder</button>
        <button class="filterknapper">Rengøring</button>
        <button class="filterknapper">Pakker</button>
	
	<section id="produktoversigt"></section>
	<template id="enkelt_produkt">
		<figure class="produkt">
			<div class="produkt_information">
            	<p class="produkt_navn"></p>
            	<p class="produkt_pris"></p>
          	</div>
			<img class="produktbillede" src="" alt="">
		</figure>
	</template>
</div>

<script>
// Her starter JS. console.log for at tjekke om der er forbindelse
// console.log("hip hurra");

// Oprettelse af variabler
const url = "https://lineberner.com/kea/2_semester/dolah/wp-json/wp/v2/soap/?per_page=100";
const liste = document.querySelector("#produktoversigt");
const skabelon = document.querySelector("template");

// Oprettelse af function 'start' (som starter så snart siden er loaded)
document.addEventListener("DOMContentLoaded", start);

// Sæt function 'start' igang og vis json/rest API indhold
function start(){
// console.log("tillykke tillykke");
getJson()
}

// Oprattelse af function 'getJson' og definer hvordanm rest API'en hentes ind, og start function 'visProdukter'
async function getJson(){
	const response = await fetch(url);
	produkter = await response.json();
	visProdukter();
}

// Oprettelse af function 'visProdukter' og definer hvilket indhold der skal vises i template. forEach = for hvert produkt vises navn, pris og billede
function visProdukter(){
	console.log(produkter);
produkter.forEach(produkt =>{
	const klon = skabelon.cloneNode(true).content;
	klon.querySelector(".produkt_navn").textContent = produkt.navn;
	klon.querySelector(".produkt_pris").textContent = produkt.pris;
	klon.querySelector(".produktbillede").src = produkt.billede[0].guid;
	klon.querySelector(".produktbillede").alt = produkt.navn;
	liste.appendChild(klon);
})
}


</script>

<?php
get_footer();
