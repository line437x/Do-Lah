<?php

get_header(); ?>

<style>
	/* RYK ALLE STYLES OVER I CUSTOM.CSS */
main {
      width: 90vw;
    }

    p,
    h1,
    h2,
    h3,
    h4 {
      font-family: "century gothic";
    }

    img {
      display: block;
      width: 100%;
      height: auto;
      padding: 0;
      border: solid 1px black;
    }

    #produkt_container {
      display: grid;
    }

    figure {
      margin: 0;
    }

    #produkt_navn_single,
    #tekst_1,
    #tekst_2,
    #tekst_3,
    #køb,
    #tekst_4 {
      border: solid 1px black;
      padding: 0.5rem;
    }

    #produkt_navn_single {
      text-align: center;
    }

    #køb {
      display: grid;
      grid-template-columns: 1fr 1fr;
      text-align: center;
    }
	#antal {
      display: flex;
    }
    #antal p {
      border: solid 1px black;
      width: 3rem;
      padding: 0.5rem;
    }

    button {
      font-family: "Century Gothic";
      font-style: bold;
      background-color: black;
      color: white;
      border: solid 1px black;
	  padding: 0.5rem;
    }
</style>

<main>
	<article id="produkt_container">
        <h1 id="produkt_navn_single"></h1>

        <figure><img class="produktbillede" src="pine.png" alt="" /></figure>

        <div id="tekst_1">
          <h3>Beskrivelse og egenskaber</h3>
          <p id="produkt_beskrivelse"></p>
        </div>

        <div id="tekst_2">
          <p id="produkt_pris"></p>
          <p id="produkt_vaegt"></p>
        </div>

        <div id="tekst_3">
          <h3>Tips og tricks</h3>
          <p id="produkt_tip"></p>
        </div>

        <div id="køb">
          <div id="antal">
            <p>-</p>
            <p>1</p>
            <p>+</p>
          </div>
          <button>Læg i kurv</button>
        </div>
        <div id="tekst_4">
          <h3>Ingredienser</h3>
          <p>Brassica Campestris (Repeseed) Oil</p>
          <p>Cannabis Sativa (Hemp) Seed Oil</p>
          <p>Cocos Nucifera (Coconut) Oil</p>
          <p>Lavandula Angustifolia (Lavender) Oil</p>
          <p>Olea Europaea (Olive) Oil</p>
        </div>
</article>
	<!-- <figure class="produkt">
		<h1 class="produkt_navn_single"></h1>
		<div class="produkt_information_single">
			<h3>Beskrivelse og egenskaber</h3>
			<p class="produkt_beskrivelse"></p>
            <p class="produkt_pris"></p>
			<p class="produkt_vaegt"></p>
			<h3>Tips og tricks</h3>
			<p class="produkt_tip"></p>
			<h3>Ingredienser</h3>
        </div>
		<img class="produktbillede" src="" alt="">
	</figure> -->

</main>

<script>
// Her starter JS. console.log for at tjekke om der er forbindelse
// console.log("hip hurra");

// Oprettelse af variabler
let produkter;

const url = "https://lineberner.com/kea/2_semester/dolah/wp-json/wp/v2/soap/"+<?php echo get_the_ID() ?>;

// Oprettelse af function 'getJson' og definer hvordanm rest API'en hentes ind, og start function 'visProdukt'
async function getJson(){
	const response = await fetch(url);
	produkt = await response.json();

	console.log(produkt);

	// Kald funktioner
	visProdukt();
}

// Oprettelse af function 'start' (som starter så snart siden er loaded)
document.addEventListener("DOMContentLoaded", start);

// Sæt function 'start' igang og vis json/rest API indhold
function start(){
	// Kald funktion
	getJson()
}

// Oprettelse af function 'visProdukt' og definer hvilket indhold der skal vises
function visProdukt(){
	document.querySelector("#produkt_navn_single").textContent = produkt.navn;
	document.querySelector(".produktbillede").src = produkt.billede[0].guid;
	document.querySelector(".produktbillede").alt = produkt.navn;
	document.querySelector("#produkt_beskrivelse").textContent = produkt.beskrivelse;
	document.querySelector("#produkt_pris").textContent = produkt.pris;		
	document.querySelector("#produkt_vaegt").textContent = produkt.vaegt;
	document.querySelector("#produkt_tip").textContent = produkt.tip;
}


</script>

<?php
get_footer();
