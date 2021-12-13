<?php

get_header(); ?>

<style>
	/* RYK ALLE STYLES OVER I CUSTOM.CSS */
main{
width: 90vw;
}

img {
  display: block;
  width: 100%;
  height: auto;
  padding: 0;
  border: solid 1px black;
}
p,
h1,
h2,
h3,
h4 {
    font-family: "century gothic";
    }
/* style på grid-produktoversigt i mobile */
#filtrerings_knapper {
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
  padding: 0.5rem;
}
.produkt_navn,
.produkt_pris {
  color: black;
}
</style>

<main>
<h1>Shop Do Lah</h1>
<p>Lækre og økologiske sæbebarer som kan bruges af hele husstanden. Alle sæbebarer fra Do Lah kan bruges på både krop og hænder, og passer til alle hudtyper. </p>

<nav id=filtrerings_knapper>
	<button id="alle_knap" data-produkt="alle">Alle</button>
</nav>

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

</main>

<script>
// Her starter JS. console.log for at tjekke om der er forbindelse
// console.log("hip hurra");

// Oprettelse af variabler
let produkter;
let produktType;
let filterProdukt = "alle";

const url = "https://lineberner.com/kea/2_semester/dolah/wp-json/wp/v2/soap/?per_page=100";
const typeUrl = "https://lineberner.com/kea/2_semester/dolah/wp-json/wp/v2/product_type";

// Oprettelse af function 'getJson' og definer hvordanm rest API'en hentes ind, og start function 'visProdukter'
async function getJson(){
	const response = await fetch(url);
	const typeData = await fetch(typeUrl);

	produkter = await response.json();
	produktType = await typeData.json();
	// console.log(produktType);

	// Kald funktioner
	visProdukter();
	opretKnapper();
}

// Her oprettes filtreringsknapperne ud fra dynamisk indhold. Her ud fra kategorien "produkttype"
function opretKnapper(){
	produktType.forEach(type=>{
		document.querySelector("#filtrerings_knapper").innerHTML += `<button class="filter" data-produkt="${type.id}">${type.name}</button>`
	})
	// Kald funktion 
	addEventListenersToButtons(); 
}
// Her gøres alle knapperne klikbarer
function addEventListenersToButtons(){
	document.querySelectorAll("#filtrerings_knapper button").forEach(knap =>{
		knap.addEventListener("click", filtrering);
	})
};

function filtrering(){
	filterProdukt = this.dataset.produkt;
	console.log(filterProdukt);

	// Kald funktion
	visProdukter();
}

// Oprettelse af function 'start' (som starter så snart siden er loaded)
document.addEventListener("DOMContentLoaded", start);

// Sæt function 'start' igang og vis json/rest API indhold
function start(){
	// Kald funktion
	getJson()
}

// Oprettelse af function 'visProdukter' og definer hvilket indhold der skal vises i template. forEach = for hvert produkt vises navn, pris og billede
function visProdukter(){
	console.log(produkter);
	const skabelon = document.querySelector("template");
	const liste = document.querySelector("#produktoversigt");
	liste.innerHTML = "";

	produkter.forEach(produkt =>{
		if ( filterProdukt == "alle" || produkt.product_type.includes(parseInt(filterProdukt))){
		const klon = skabelon.cloneNode(true).content;
		klon.querySelector(".produkt_navn").textContent = produkt.navn;
		klon.querySelector(".produkt_pris").textContent = produkt.pris;
		klon.querySelector(".produktbillede").src = produkt.billede[0].guid;
		klon.querySelector(".produktbillede").alt = produkt.navn;
		klon.querySelector("figure").addEventListener("click", ()=>{location.href = produkt.link});
		liste.appendChild(klon);
		}
	})
}


</script>

<?php
get_footer();
