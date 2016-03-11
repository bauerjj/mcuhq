@extends('layouts.full')

@section('head')
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css"
          type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/css/selectize.min.css"
          type="text/css"/>

@endsection

@section('header')
    <header class="main-header">
        <div class="container">

            <ol class="breadcrumb ">
                <li><a href="/">Home</a></li>
                <li class="active">Edit {{ $post->title }}</li>
            </ol>
        </div>
    </header>

@endsection


@section('center')
    <form method="post" action='{{ url("/update") }}' class="input-post form-horizontal" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="post_id" value="{{ $post->id }}{{ old('post_id') }}">
        <div class="form-group">
            <input required="required" placeholder="Enter title here" type="text" name = "title" class="form-control" value="@if(!old('title')){{$post->title}}@endif{{ old('title') }}"/>
        </div>
        <div class="form-group">
            <input type="hidden" name="body" id="body-text">

        @if(!old('body'))
            <div id="editor">{!! $post->body !!}</div>

        @endif
          <div id="editor">{!! old('body') !!}</div>
        </div>

        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong><i class="fa fa-bullhorn"></i></strong> If you don't see a particular micocontroller or
            compiler/assembler that you'd like to add, please
            email a short note to <a href="mailto:contact@mcuhq.com?Subject=Create%20Post"
                                     target="_top">contact@mcuhq
                .com</a>!
        </div>
        <div class="row">
            <div class="col-md-6">

                <div class="form-group">
                    <label for="tags" class="col-sm-1 col-md-3 control-label">Tags </label>

                    <div class="col-sm-11 col-md-9">
                        <input value="{{ old('tags') }}" placeholder="Tags" type="text" name="tags" id="tags"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="more_info_link" class="col-sm-1 col-md-3 control-label">Source Link </label>

                    <div class="col-sm-11 col-md-9">
                        <input value="{{ old('more_info_link') }}" placeholder="(Optional) More Info Link i.e. github" type="text"
                               name="more_info_link" class="form-control" id="more_info_link"/>

                    </div>
                </div>
                <div class="form-group">
                    <label for="topic-dropdown" class="col-sm-1 col-md-3 control-label">Category(s) </label>
                    <input type="hidden" name="topics" id="topics-input">

                    <div class="col-sm-11 col-md-9">
                        <select id="topic-dropdown" multiple="multiple">
                            @foreach($categories as $cat)
                                <option value="{{$cat->id}}">{{$cat->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>






        @if($post->active == '1')
            <input type="submit" name='publish' class="btn btn-success btn-form" value = "Update"/>
        @else
            <input type="submit" name='publish' class="btn btn-success btn-form" value = "Publish"/>
        @endif
        <input type="submit" name='save' class="btn btn-default btn-form" value = "Save As Draft" />
        <a href="{{  url('delete/'.$post->id.'?_token='.csrf_token()) }}" class="btn btn-danger">Delete</a>
    </form>

@endsection

@section('script')
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/js/standalone/selectize.min.js"></script>

    <script>
        var i;
//        var tags = [
//            {tag: 'dog'}, {tag: 'cat'}, {tag: 'girfaf'}, {tag: 'elephant'}, {tag: 'tiger'}, {tag: 'moose'}, {tag: 'duck'}, {tag: 'bird'},
//        ]
        var tags ={!!$tags!!}
        $('#tags').selectize({
            plugins: ['remove_button'],
            delimiter: ',',
            persist: false,
            valueField: 'name',
            labelField: 'name',
            searchField: 'name',
            maxItems: 6,
            options: tags,
            create: function (input) {
                return {
                    name: input // enter here when adding a new tag to the mix
                }
            }
        });

        $('#language-dropdown').multiselect();



        $('#topic-dropdown').multiselect({
            maxHeight: 200,
            dropUp: false,
            onChange: function (option, checked) {
                // Get selected options.
                var selectedOptions = $('#topic-dropdown option:selected');

                if (selectedOptions.length >= 4) {
                    // Disable all other checkboxes.
                    var nonSelectedOptions = $('#topic-dropdown option').filter(function () {
                        return !$(this).is(':selected');
                    });

                    var dropdown = $('#topic-dropdown').siblings('.multiselect-container');
                    nonSelectedOptions.each(function () {
                        var input = $('input[value="' + $(this).val() + '"]');
                        input.prop('disabled', true);
                        input.parent('li').addClass('disabled');
                    });

                }
                else {
                    // Enable all checkboxes.
                    var dropdown = $('#topic-dropdown').siblings('.multiselect-container');
                    $('#topic-dropdown option').each(function () {
                        var input = $('input[value="' + $(this).val() + '"]');
                        input.prop('disabled', false);
                        input.parent('li').addClass('disabled');
                    });
                }
            }
        });

        $('#micro').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200,
            dropUp: true
        });

        $('#compiler-assembler').multiselect({
            enableFiltering: false,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200,
            dropUp: true
        });


        var csrftoken = '{{ csrf_token() }}';


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrftoken
            }
        });

        $('#editor').markdownEditor({
            preview: true,
            imageUpload: true, // Activate the option
            uploadPath: '/upload-image' + '?_token=H0jOJqUa9voBwA5VDDpfzcj0GXfqafwCwpmnvC5T', // Path of the server side script that receive the files

            onPreview: function (content, callback) {
                callback(marked(content));
            }
        });

        $('#editor').html({{ old('body') }}) // NEED THIS to repopluate form if errors!

        $(function () {
            $('.btn-form').click(function () { // enter here if publishing or drafting
                var mysave = $('#editor').markdownEditor('content')
                $('#body-text').val(mysave);
                $('#compiler-assembler-input').val($('#compiler-assembler').val())
                $('#micro-input').val($('#micro').val())
                $('#topics-input').val($('#topic-dropdown').val())
                $('#language-input').val($('#language-dropdown').val())


            });
        });

    </script>







@endsection
