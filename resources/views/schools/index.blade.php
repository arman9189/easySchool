@extends('adminlte::page')

@section('title', 'Easy School | Schools')

@section('content_header')
    <h1>
    	School Management
	    <div class="pull-right">
			  <a class="btn btn-success" href="{{ route('schools.create') }}"> Add a New School</a>
			</div>
		</h1>
@stop

@section('content')
	<h4>Schools</h4>
	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>No</th>
					<th>নাম</th>
					<th>EIIN</th>
					<th>ঠিকানা</th>
					<th>চলতি শিক্ষাবর্ষ</th>
					<th>ক্লাস</th>
					<th width="280px">Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($schools as $school)
					<tr>
						<td>No</td>
						<td>{{ $school->name }}</td>
						<td>{{ $school->eiin }}</td>
						<td>{{ $school->address }}</td>
						<td>{{ $school->currentsession }}</td>
						<td>{{ $school->classes }}</td>
						<td>
							{{-- edit modal--}}
							<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal{{ $school->id }}" data-backdrop="static">
								<i class="fa fa-pencil"></i>
							</button>
							<!-- Trigger the modal with a button -->
						  <!-- Modal -->
						  <div class="modal fade" id="editModal{{ $school->id }}" role="dialog">
						    <div class="modal-dialog modal-lg">
						      <div class="modal-content">
						        <div class="modal-header modal-header-primary">
						          <button type="button" class="close" data-dismiss="modal">&times;</button>
						          <h4 class="modal-title">{{ $school->name }} সম্পাদনাঃ</b></h4>
						        </div>
						        {!! Form::model($school, ['route' => ['schools.update', $school->id], 'method' => 'PUT']) !!}
						        <div class="modal-body">
						            <div class="row">
						                <div class="col-md-12">
				                        <div class="row">
				                            <div class="col-md-6">
				                                <div class="form-group">
				                                    <strong>প্রতিষ্ঠানের নাম নামঃ</strong>
				                                    {!! Form::text('name', null, array('placeholder' => 'নাম','class' => 'form-control', 'required' => '')) !!}
				                                </div>
				                            </div>
				                            <div class="col-md-6">
				                                <div class="form-group">
				                                    <strong>ইআইআইএনঃ</strong>
				                                    {!! Form::text('eiin', null, array('placeholder' => 'ইআইআইএন','class' => 'form-control', 'required' => '')) !!}
				                                </div>
				                            </div>
				                        </div>
				                        <div class="row">
				                            <div class="col-md-6">
				                                <div class="form-group">
				                                  <strong>চলতি অ্যাকাডেমিক সেশনঃ (শিক্ষাবর্ষ)</strong>
				                                  <select class="form-control" name="currentsession" required="">
				                                    <option value="" selected disabled>শিক্ষাবর্ষ নির্ধারণ করুন</option>
				                                  @php
				                                    $y = date('Y')-2;
				                                    for($y; $y<=2038; $y++) {
				                                  @endphp
				                                      <option 
																							@if($school->currentsession == $y)
																							selected 
																							@endif
				                                       value="{{ $y }}">{{ $y }}</option>
				                                  @php
				                                    }
				                                  @endphp
				                                  </select>
				                                </div>
				                            </div>
				                            <div class="col-md-6">
				                                <div class="form-group">
				                                  <strong>ভর্তি প্রক্রিয়াঃ</strong>
				                                  <br/>
				                                  <label style="margin-right: 40px;">
				                                  <input type="radio" name="isadmissionon" value="0" 
																					@if($school->isadmissionon == 0)
																					checked="checked" 
																					@endif
				                                  required> বন্ধ</label>
				                                  <label style="margin-right: 40px;">
				                                  <input type="radio" name="isadmissionon" value="1"
																					@if($school->isadmissionon == 1)
																					checked="checked" 
																					@endif
				                                  > চলছে</label>
				                                </div> 
				                            </div>
				                        </div> 
				                        <div class="row">
				                            <div class="col-md-6">
				                                <div class="form-group">
				                                    <strong>ঠিকানাঃ</strong>
				                                    {!! Form::text('address', null, array('placeholder' => 'ঠিকানা','class' => 'form-control', 'required' => '')) !!}
				                                </div>
				                            </div>
				                            <div class="col-md-6">
				                                <div class="form-group">
				                                  <strong>শেষ সংঘটিত পরীক্ষার ফলাফলঃ</strong>
				                                  <br/>
				                                  <label style="margin-right: 40px;">
				                                  <input type="radio" name="isresultpublished" value="0" 
																					@if($school->isresultpublished == 0)
																					checked="checked" 
																					@endif
				                                  required> বন্ধ আছে</label>
				                                  <label style="margin-right: 40px;">
				                                  <input type="radio" name="isresultpublished" value="1"
																					@if($school->isresultpublished == 1)
																					checked="checked" 
																					@endif
				                                  > দেওয়া হয়েছে</label>
				                                </div> 
				                            </div>
				                        </div>
				                        <div class="form-group">
				                          <strong>ক্লাসঃ</strong>
				                          <br/>
				                          @php
				                          $classes = explode(',', $school->classes);
				                          @endphp
				                          @for($clss = 1;$clss<=10;$clss++)
				                            <label style="margin-right: 40px;">
				                            <input type="checkbox" name="classes[]" value="{{ $clss }}" class="classes"
																		@if(in_array($clss, $classes)) checked @endif
				                            > {{ $clss }}
				                            </label>
				                          @endfor
				                        </div>  
				                        <div class="row">
				                            <div class="col-md-6">
				                                <div class="form-group">
				                                  <strong>চলতি পরীক্ষার নাম নির্ধারণ করুন</strong>
				                                  <select class="form-control" name="currentexam">
				                                    <option selected disabled>চলতি পরীক্ষার নাম নির্ধারণ করুন</option>
				                                    <option value="halfyearly"
																						@if($school->currentexam == 'halfyearly')
																						  selected 
																						@endif
				                                    >অর্ধবার্ষিকী/প্রাক-নির্বাচনী পরীক্ষা</option>
				                                    <option value="final"
																						@if($school->currentexam == 'final')
																						  selected 
																						@endif
				                                    >বার্ষিক/নির্বাচনী পরীক্ষা</option>
				                                  </select>
				                                </div>
				                            </div>
				                            <div class="col-md-6">
				                                <div class="row">
				                                    <div class="col-md-6">
				                                        <div class="form-group">
				                                            <label>মনোগ্রাম</label>
				                                            <div class="input-group">
				                                                <span class="input-group-btn">
				                                                    <span class="btn btn-default btn-file">
				                                                        ব্রাউজ করুন <input type="file" id="imgInp" name="monogram">
				                                                    </span>
				                                                </span>
				                                                <input type="text" class="form-control" readonly>
				                                            </div>
				                                        </div>
				                                    </div>
				                                    <div class="col-md-6">
				                                        <img src="https://via.placeholder.com/120x120?text=Monogram" id='img-upload' style="height: 120px; width: auto; padding: 5px; float: right;" />
				                                    </div>
				                                </div>
				                            </div>
				                        </div>
						                </div>
						            </div>
						        </div>
						        <div class="modal-footer">
						          <button type="submit" class="btn  btn-success">Save</button>
						          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						        </div>
						        {!! Form::close() !!}
						      </div>
						    </div>
						  </div>
						  {{-- edit modal--}}
					    {{-- delete modal--}}
					    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $school->id }}" data-backdrop="static"><i class="fa fa-trash" aria-hidden="true"></i></button>
					      	<!-- Trigger the modal with a button -->
				        	<!-- Modal -->
					        <div class="modal fade" id="deleteModal{{ $school->id }}" role="dialog">
					          <div class="modal-dialog modal-md">
					            <div class="modal-content">
					              <div class="modal-header modal-header-danger">
					                <button type="button" class="close" data-dismiss="modal">&times;</button>
					                <h4 class="modal-title">Delete confirmation</h4>
					              </div>
					              <div class="modal-body">
					                Delete school <b>{{ $school->name }}</b>?
					              </div>
					              <div class="modal-footer">
					                {!! Form::model($school, ['route' => ['schools.destroy', $school->id], 'method' => 'DELETE']) !!}
					                    <button type="submit" class="btn btn-danger">Delete</button>
					                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					                {!! Form::close() !!}
					              </div>
					            </div>
					          </div>
					        </div>
				      {{-- delete modal--}}
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>	
	</div>
@stop