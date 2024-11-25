<?php if(count($templateParams["prodotto"])==0): ?>
<article>
	<p>Prodotto non presente</p>
</article>
<?php 
else:
	$prodotto = $templateParams["prodotto"][0];
?>
<article>
	<section>
		<h1>
			<?php echo $prodotto["nome"]; ?>
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
	<?php if(count($templateParams["specifiche_prodotto"])==0): ?>
	<section>
		<p>Specifiche prodotto non presenti</p>
	</section>
	<?php 
else:
		$specificheProdotto = $templateParams["specifiche_prodotto"];
	?>
	<section>
		<h2>Caratteristiche</h2>

		<table>
			<?php foreach($specificheProdotto as $specifica): ?>
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
	<?php endif; ?>
</article>
<?php endif; ?>