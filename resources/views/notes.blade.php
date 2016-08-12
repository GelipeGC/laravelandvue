@extends('layout')
@section('content')
	<div class="container">
		<h1>Developers Ideas</h1>
		<p v-show="error" class="alert alert-danger" id="error_message">@{{ error}}</p>
		<table class="table table-striped">
			<tr>
				<th>Categoria</th>
				<th>Nota</th>
				<th>Acciones</th>
			</tr>
			<tr v-for="note in notes" is="note-row" :note.sync="note" :categories="categories">
			</tr>
			<tr>
	            <td><select-category :categories="categories" :id.sync="new_note.category_id"></select-category></td>
	            <td><input type="text" v-model="new_note.note" class="form-control">
	            	<ul v-if="errors.length">
	            		<li v-for="error in errors" class="active-danger">@{{ error}}</li>
	            	</ul>
	            </td>
	            <td>
	                <a href="#" @@click.prevent="createNote()">
	                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
	                </a>
	            </td>
	        </tr>
			
		</table>
	</div>
	<pre> @{{ $data | json}}</pre>
@endsection

@section('scripts')
	@verbatim
		<template id="select_category_tpl">
			<select v-model="id" class="form-control">
						<option value="">Seleccione una categoria</option>
						<option v-for="category in categories" :value="category.id">
						{{ category.name }}
						</option>
					</select>
		</template>

		<template id="note_row_tpl">
			<tr>
			<template v-if="! editing">
				<td>{{ note.category_id | category }}</td>
				<td>{{ note.note }}</td>
				<td>
					<a href="#" @click=edit()><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
					<a href="#" @click="remove()"><span class="glyphicon glyphicon-trash"></span></a>
				</td>
			</template >
			
			<template v-else>
				<td>
					<select-category :categories="categories" :id.sync="draft.category_id"></select-category>
				</td>
				<td><input type="text" v-model="draft.note" class="form-control">
				<ul v-if="errors.length">
	            		<li v-for="error in errors" class="active-danger">{{ error}}</li>
	            </ul>
				</td>
				<td>
					<a href="#" @click.prevent="update()">
						<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
					</a>
					<a href="#" @click.prevent="cancel()">
						<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
					</a>
				</td>
			</template>
				
			</tr>
		</template>
	@endverbatim
	 <script src="https://code.jquery.com/jquery-2.2.3.js"
            integrity="sha256-laXWtGydpwqJ8JA+X9x2miwmaiKhn8tVmOVEigRNtP4="
            crossorigin="anonymous"></script>
	<script src="{{url('js/vue.js')}}"></script>
	<script src="{{ url('js/main.js')}}"></script>
@endsection