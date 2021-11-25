<link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url(); ?>assets/css/admincss.css" rel="stylesheet" type="text/css" />
	
<section class="container content02">

	<div class="row">
		<div class="Head01 col-11 m-auto">            
			<h1>Mailbox</h1>
		</div>
	</div>

	<div class="col-sm-12">

		<div class="row">

			<div class = 'col-sm-3'>

				<div class = 'card card-info'>
					<div class = 'card-body'>
						<h3> Users </h3>
							<?php foreach ($receivers as $receiver) { ?>
							<a href = '#' class = 'message-receiver' data-user-id =  '<?php echo $receiver->userId; ?>'>
								<div class = 'card card-default card_margin'>
									<div class = 'card-body'>
										<?php echo $receiver->name; ?>
									</div>
								</div>
							</a>
							<?php } ?>
					</div>
				</div>

			</div>
				
			<div class = 'col-sm-9' id = 'conversation-container'>
				<div class = 'card card-info'>
					<div class="card-body">
						Please choose a user
					</div>
				</div>
			</div>

		</div>
		
	</div>

</section>

<script>
$(document).ready(function(){
	function reloadConversation(userID) {
		$('#conversation-container').load('<?php echo base_url(); ?>mailbox/getConversation/<?php echo $this->session->userdata('userId')?>/'+userID);
	}
	
	$(document).on('click', '.message-receiver', function() {
		reloadConversation($(this).data('user-id'));
		return false;
	});

	$(document).on('submit', '#send-message-form', function() {
		var postUrl = '<?php echo base_url(); ?>mailbox/sendMessage';
		var receiver = $(this).data('receiver');
		
		$.post(
			postUrl,
			$(this).serialize(),
			function(){
				reloadConversation(receiver);
			});

			return false;
	});

	$(document).on('click', '.delete-message', function() {
		var messageID = $(this).data('message-id');
		var endpoint = '<?php echo base_url(); ?>mailbox/deleteMessage/'+messageID;

		$.get(endpoint, function() {
			reloadConversation(messageID);
		});

		return false;
	});
});
</script>