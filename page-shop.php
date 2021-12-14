<?php

get_header(); ?>

<style>
	/* RYK ALLE STYLES OVER I CUSTOM.CSS */
main {
  display: grid;
  grid-template-columns: 1fr minmax(0, 1000px) 1fr;
}
main section {
  grid-column: 2/3;
}

#indledning{
display: grid;
justify-content: center;
padding-bottom: 2.5rem;
}

#indledning h1, #indledning p{
	text-align: center;
}

/* style på grid-produktoversigt i mobile */
#filtrerings_knapper {
      display: grid;
      grid-template-columns: 1fr 1fr;
    }
#filter_knapper, #alle_knap{
	background-color: white;
	color: black;
	border: solid 1px black;
}

#produktoversigt{
	/* grid-column: 1/3; */
	display: grid;
	grid-template-columns: 1fr 1fr;
	/* grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); */
	}

#alle_knap {
      grid-column: 1/3;
    }

/* Style på produkt-boks i oversigt */
.produkt{
	cursor: pointer;
}

.produkt_information {
  position: absolute;
  padding: 0.5rem;
}
.produkt_navn,
.produkt_pris {
  color: black;
}
@media (min-width: 700px) {
	#produktoversigt{
		grid-template-columns: 1fr 1fr 1fr;
		}	
	#indledning{
		padding-bottom: 5rem;
	}
}
@media (min-width: 1000px) {
	#produktoversigt{
		grid-template-columns: repeat(4, 1fr);
		}	
}

</style>

<main>
	<section>
<article id="indledning">
	<h1>Shop Do Lah</h1>
	<p>Lækre og økologiske sæbebarer som kan bruges af hele husstanden. Alle sæbebarer fra Do Lah kan bruges på både krop og hænder, og passer til alle hudtyper. </p>
</article>
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
</section>
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
		document.querySelector("#filtrerings_knapper").innerHTML += `<button id="filter_knapper" class="filter" data-produkt="${type.id}">${type.name}</button>`
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
