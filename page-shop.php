<?php

get_header(); ?>


<section id="produktoversigt"></section>
<template>
	<article class="produkt">
		<p class="produkt_navn"></p>
		<p class="pris"></p>
		<img class="produktbillede" src="" alt="">
	</article>
</template>

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
	klon.querySelector(".pris").textContent = produkt.pris;
	klon.querySelector(".produktbillede").src = produkt.billede[0].guid;
	klon.querySelector(".produktbillede").alt = produkt.navn;
	liste.appendChild(klon);
})
}


</script>

<?php
get_footer();
