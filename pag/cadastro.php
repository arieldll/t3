<div>
	<form action="?p=cadastro" method="post">
		<div>
			Nome: <br />
			<input type="text" name="cnome" value="<?php echo valor_campo("cnome"); ?>" class="campo_meia" /> <br />
			Login: <br />
			<input type="text" name="clogin" value="<?php echo valor_campo("clogin"); ?>" class="campo_meia" /> <br />
			Senha: <br />
			<input type="password" name="csenha" value="<?php echo valor_campo("csenha"); ?>" class="campo_meia" /> <br />
			Confirmar a senha: <br />
			<input type="password" name="ccsenha" value="<?php echo valor_campo("ccsenha"); ?>" class="campo_meia" /> <br />
			Email: <br />
			<input type="text" name="cemail" value="<?php echo valor_campo("cemail"); ?>" class="campo_meia" />
		</div>
		<div style="margin-top: 5px;">
			<input type="submit" value="Enviar" class="botao_meia" />
			<input type="submit" value="Limpar" class="botao_meia" />
		</div> 
	</form>
</div>
