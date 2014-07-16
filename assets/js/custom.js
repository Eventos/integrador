function addInscricao(){
	i = $('.valor').size();
	block = '<div class="valor"><br>'
	block += '<label>De: &nbsp<input type="date" name="valores['+i+'][\'de\']">&nbsp';
	block += '<label>Até: &nbsp<input type="date" name="valores['+i+'][\'ate\']">&nbsp';
	block += '<label>Valor: &nbsp<input type="text" name="valores['+i+'][\'valor\'"]"> &nbsp';
	block += '<a href="#" onclick="removeInscricao()">Excluir</a><br>'
	block += '<div>';
	$('#valores-inscricoes').append(block);
	event.preventDefault();
}

function removeInscricao(){
	$('.valor').last().remove();
	event.preventDefault();
}
setTimeout(function(){
     $('.alert').fadeToggle('slow');
},1500);
