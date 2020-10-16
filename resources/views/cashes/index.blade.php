@extends('layouts.app')
@section('custom_styles')
	@include('bootstrap-datepicker.style')
	@include('datatables.style')
@endsection
@section('content')
	<div class="container">
		<h3>HISTORICO DE CAJAS</h3>
		<hr>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="row">
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<div class="card">
						<div class="card-body">
								<div class="row">
									<div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6">
										{{ csrf_field() }}
										@include('commons.asterix-sm')<label>FECHA</label>
										<input type="text" id="searchDate"  name="searchDate" class="datepicker form-control" placeholder="dd/mm/aaaa">
									</div>
									<div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6">
										<br>
										<button class="btn btn-md btn-success">BUSCAR</button>
									</div>
								</div>
						</div>
					</div>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<div class="card">
						<div class="card-body row text-center">
							<div class="col">
								<div class="text-value-xl" id="div-cashing-total">$ <span></span></div>
								<div class="text-uppercase text-muted small">EFECTIVO</div>
							</div>
							<div class="vr"></div>
							<div class="col">
								<div class="text-value-xl" id="div-checks-total" style="color: #ff3838;">$ <span></span></div>
								<div class="text-uppercase text-muted small">CHEQUES</div>
							</div>
						</div>
						<div class="card-body row text-center">
							<div class="col">
								<div class="text-value-xl" id="div-banks-total" style="color: #38c172;">$ <span></span></div>
								<div class="text-uppercase text-muted small">BANCO</div>
							</div>
							<div class="vr"></div>
							<div class="col">
								<div class="text-value-xl" id="div-mercadopago-total" style="color: #009ee3;">$ <span></span></div>
								<div class="text-uppercase text-muted small">MERCADOPAGO</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4 col-lg-4">
					<div class="card">
						<div class="card-body row text-center">
							<div class="col">
								<div class="text-value-xl" id="div-cash-in-total">$ <span></span></div>
								<div class="text-uppercase text-muted small">INGRESOS</div>
							</div>
							<div class="vr"></div>
							<div class="col">
								<div class="text-value-xl" id="div-cash-out-total">$ <span></span></div>
								<div class="text-uppercase text-muted small" style="color: ">EGRESOS</div>
							</div>
						</div>
						<div class="card-body row text-center">
							<div class="col">
								<div class="text-value-xl" id="div-cash-total">$ <span></span></div>
								<div class="text-uppercase text-muted small">TOTAL CAJA</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row justify-content-center" id="ingresos-egresos">

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="card">
							<div  class="card-header">INGRESOS</div>
							<div id="card-ingresos"></div>

							<div class="card-footer">
								<div class="row">
									<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
										<label>CUOTA INICIAL</label><br/>
										<input id="inicial" type="text" name="inicial" class="form-control" readonly="readonly">
									</div>
									<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
										<label>EFECTIVO</label><br/>
										<input id="efectivo" type="text" name="efectivo" readonly="readonly"
											   class="form-control">
									</div>
									<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
										<label>CHEQUES</label><br/>
										<input id="cheques" type="text" name="cheques" readonly="readonly" class="form-control" style="background-color: #ff3838;color: white">
									</div>
									<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
										<label>BANCO</label><br/>
										<input id="transferencias" type="text" name="tranferencias" readonly="readonly" class="form-control" style="background-color: #38c172;color: white">
									</div>
									<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
										<label>MERCADO PAGO</label><br/>
										<input id="mercadopago" type="text" name="mercadopago" readonly="readonly" class="form-control" style="background-color: #009ee3;color: white">
									</div>
									<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
										<label>TOTAL INGRESOS</label><br/>
										<input id="ingresos" type="text" name="ingresos" class="form-control"
											   readonly="readonly">
									</div>
								</div>

							</div>
						</div>
					</div>

					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="card">
							<div class="card-header">EGRESOS</div>
							<div id="card-egresos">

							</div>

							<div class="card-footer">
								<div class="row">
									<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
										<label>EFECTIVO</label><br/>
										<input id="efectivo_out" type="text" name="efectivo_out" readonly="readonly"
											   class="form-control">
									</div>
									<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
										<label>CHEQUES</label><br/>
										<input id="cheques_out" type="text" name="cheques_out" readonly="readonly" class="form-control" style="background-color: #ff3838;color: white">
									</div>
									<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
										<label>BANCO</label><br/>
										<input id="transferencias_out" type="text" name="transferencias_out" readonly="readonly" class="form-control" style="background-color: #38c172;color: white">
									</div>
									<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
										<label>MERCADO PAGO</label><br/>
										<input id="mercadopago_out" type="text" name="mercadopago_out" readonly="readonly" class="form-control" style="background-color: #009ee3;color: white">
									</div>
									<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
										<label>TOTAL EGRESOS</label><br/>
										<input id="egresos" type="text" name="egresos" class="form-control" readonly="readonly">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>


@endsection

@section('custom_scripts')
	@include('datatables.script')
	@include('bootstrap-datepicker.script')
	@include('commons.autonumeric')
	@include('cashes.jsindex')
@endsection
