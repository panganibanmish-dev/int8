<div class = 'card card-info'>
		<div class="card-body">
			<?php foreach ($messages as $message) { ?>
			<div class = 'row'>
				<div class = 'col-md-12 message_row_margin_adjust'>
				<?php if ($this->session->userdata('userId') == $message->senderId) { ?>
					<div class = 'card  float-right'>
					<?php } else { ?>
					<div class = 'card  float-left'>
					<?php } ?>
					<?php if ($this->session->userdata('userId') == $message->senderId) { ?>
						<div class = 'card-header'>
					<?php } else { ?>
						<div class = 'card-header card-info-custom'>
					<?php } ?>
						<p class = ''> <?php echo $message->content; ?> </p></div>
						<div class = 'card-body float-right'>
							<blockquote class="blockquote mb-0">
								<footer class="blockquote-footer"><?php echo $message->senderName; ?> 
								<cite title="Source Title"><?php echo date('d M Y', strtotime($message->date_added))?></cite>
								&nbsp;&nbsp;<a href = '#' class = 'delete-message' data-message-id = '<?php echo $message->id; ?>'><i class = 'fa fa-trash'></i></a>
								</footer>
							</blockquote>	
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
			<div class = 'row'>
				<div class = 'col-md-12'>
					<form id = 'send-message-form' class = 'form' data-receiver = '<?php echo $sender; ?>'>
						<div class = 'form-group form-inline'>
							<input type = 'hidden' name = 'receiver' value = '<?php echo $sender; ?>'/>
							<input type = 'hidden' name = 'sender' value = '<?php echo $this->session->userdata('userId'); ?>'/>
							<input type = 'text' class = 'form-control' name = 'content' placeholder = 'Type message' style = 'width:85%;'>
							<button type = 'submit' class = 'btn btn-primary'>SEND</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>