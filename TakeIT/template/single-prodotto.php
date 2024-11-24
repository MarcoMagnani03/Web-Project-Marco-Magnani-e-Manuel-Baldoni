<article>
	<section>
		<h1>
			<?php echo $templateParams["prodotto"]["nome"]; ?>
		</h1>

		<section>
			<h6>4.6</h6>
			<ul>
				<li><em aria-hidden="true" class="fa-solid fa-star"></em></li>
				<li><em aria-hidden="true" class="fa-solid fa-star"></em></li>
				<li><em aria-hidden="true" class="fa-solid fa-star"></em></li>
				<li><em aria-hidden="true" class="fa-solid fa-star"></em></li>
				<li><em aria-hidden="true" class="fa-regular fa-star"></em></li>
			</ul>
			<h6>(550)</h6>
			<a href="#recensioni">vedi recensioni</a>
		</section>


	</section>

	<section>
		<h2>Caratteristiche</h2>

		<table>
			<?php foreach($templateParams["prodotto"]["specifiche"] as $specifica): ?>
				<tr>
					<th>
					<?php echo $specifica["nome"]; ?>
					</th>
					<td>
						<?php echo $specifica["contenuto"]; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	</section>
</article>