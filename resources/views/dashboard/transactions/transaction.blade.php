<div class="container-fluid spark-screen">
	<div class="row">
		<div class="box box-solid box-default">
			<div class="box-header">
				<h4 class="box-title">
					<i class="fa fa-list-alt"></i> Start Transaction
				</h4>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-md-6 col-sm-12 col-xs-12">
						<div class="info-box bg-aqua">
							<span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
							<div class="info-box-content">

								<span class="info-box-text">Withdrawal</span> <span
									class="info-box-number"
								>Wallet to User </span> <span class="pull-right"> <a href="#"
									onclick="changeContent('transactions/debit')"
									class="btn btn-default btn-md"
								>Debit</a>
								</span>
								<div class="progress">
									<div class="progress-bar" style="width: 100%"></div>
								</div>
								<span class="progress-description">Request for a payment to your
									bank account</span>

							</div>

							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->
					<div class="col-md-6 col-sm-12 col-xs-12">
						<div class="info-box bg-green">
							<span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Deposit</span> <span
									class="info-box-number"
								>User to Wallet</span>
								<div class="pull-right">
									<a href="#" onclick="changeContent('transactions/credit')"
										class="btn btn-default btn-md"
									>Credit</a>
								</div>
								<div class="progress">
									<div class="progress-bar" style="width: 100%"></div>
								</div>
								<span class="progress-description">Increase your wallet balance,
									by paying to Bluegleam.</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<div class="col-md-6 col-sm-12 col-xs-12">
						<div class="info-box bg-yellow">
							<span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
							<div class="info-box-content">

								<span class="info-box-text">Transfer from</span> <span
									class="info-box-number"
								>Holding to Wallet</span> <span class="pull-right"> <a href="#"
									onclick="changeContent('transactions/holding')"
									class="btn btn-default btn-md"
								>Transfer</a>
								</span>
								<div class="progress">
									<div class="progress-bar" style="width: 100%"></div>
								</div>
								<span class="progress-description">Transfer gained interest or
									matured capital to wallet</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<div class="col-md-6 col-sm-12 col-xs-12">
						<div class="info-box bg-red">
							<span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Transfer from</span> <span
									class="info-box-number"
								>Wallet to Wallet </span> <span class="pull-right"> <a href="#"
									onclick="changeContent('transactions/wallet')"
									class="btn btn-default btn-md"
								>Transfer</a>
								</span>
								<div class="progress">
									<div class="progress-bar" style="width: 100%"></div>
								</div>
								<span class="progress-description">Transfer coins to another
									user.</span>

							</div>

							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->
				</div>
			</div>
		</div>
	</div>
</div>