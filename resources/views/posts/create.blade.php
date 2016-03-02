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
                <li class="active">New Post</li>
            </ol>
        </div>
    </header>

@endsection


@section('center')
            <form action="/new-post" method="post" class="input-post form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <label for="title" class="col-sm-1 control-label">Title </label>

                    <div class="col-sm-11 ">
                        <input required="required" value="{{ old('title') }}" placeholder="Enter title here" type="text"
                               name="title" class="form-control" id="title"/>
                    </div>
                </div>
                {{--<div class="form-group">
                    <textarea name='body'class="form-control">{{ old('body') }}</textarea>
                </div>--}}
                <input type="hidden" name="body" id="body-text">

                <div id="editor">{{ old('body') }}</div>
                <br/>

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
                    <label for="github" class="col-sm-1 col-md-3 control-label">Github </label>

                    <div class="col-sm-11 col-md-9">
                        <input value="{{ old('github') }}" placeholder="(optional) Github Link" type="text"
                               name="github" class="form-control" id="github"/>

                    </div>
                </div>
                <div class="form-group">
                    <label for="topic-dropdown" class="col-sm-1 col-md-3 control-label">Topic(s) </label>
                    <input type="hidden" name="topics" id="topics-input">

                    <div class="col-sm-11 col-md-9">
                        <select id="topic-dropdown" multiple="multiple">
                            <option value="1">Audio</option>
                            <option value="2">Networking</option>
                        </select>
                    </div>
                </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="title" class="col-sm-1 col-md-3 control-label">Source</label>

                <div class="col-sm-11 col-md-9">
                    <div style="position:relative;">
                        <a class='btn btn-primary' href='javascript:;'>
                            Choose Zip File...
                            <input type="file"
                                   style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;'
                                   name="file_source" size="40" onchange='$("#upload-file-info").html($(this).val());'>
                        </a>
                        &nbsp;
                        <span class='label label-info' id="upload-file-info"></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="micro" class="col-sm-1 col-md-3 control-label">Micro(s) </label>
                <input type="hidden" name="micro" id="micro-input">

                <div class="col-sm-9">
                    <select id="micro" multiple="multiple">
                        <optgroup label="Microchip">
                            <option value="1-1">MCHP All</option>
                            <option value="1-2">PIC10</option>
                            <option value="1-3">PIC12</option>
                        </optgroup>
                        <optgroup label="Atmel">
                            <option value="2-1">Arduino</option>
                            <option value="2-2">AVR</option>
                        </optgroup>
                        <optgroup label="Atmel">
                            <option value="2-1">Arduino</option>
                            <option value="2-2">AVR</option>
                        </optgroup>
                        <optgroup label="Atmel">
                            <option value="2-1">Arduino</option>
                            <option value="2-2">AVR</option>
                        </optgroup>
                        <optgroup label="Atmel">
                            <option value="2-1">Arduino</option>
                            <option value="2-2">AVR</option>
                        </optgroup>
                    </select>
                </div>
                </div>

            <div class="form-group">
                <label for="compiler-assembler" class="col-sm-1 col-md-3 control-label">Compiler Assembler </label>
                <input type="hidden" name="compiler-assembler" id="compiler-assembler-input">

                <div class="col-sm-11 col-md-9">
                    <select id="compiler-assembler" multiple="multiple" id="compiler-assembler">
                        <option value="Audio">Audio</option>
                        <option value="Networking">Networking</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <input type="submit" name='publish' class="btn btn-success btn-form" value="Publish"/>
    <input type="submit" name='save' class="btn btn-default btn-form" value="Save Draft"/>
    <br/>
    <br/>
    <br/>

    </form>

@endsection

@section('script')
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/js/standalone/selectize.min.js"></script>

    <script>
        var i;
        var tags = [
            {tag: 'dog'}, {tag: 'cat'}, {tag: 'girfaf'}, {tag: 'elephant'}, {tag: 'tiger'}, {tag: 'moose'}, {tag: 'duck'}, {tag: 'bird'},
        ]
        $('#tags').selectize({
            plugins: ['remove_button'],
            delimiter: ',',
            persist: false,
            valueField: 'tag',
            labelField: 'tag',
            searchField: 'tag',
            options: tags,
            create: function (input) {

                return {
                    tag: input
                }
            }
        });


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


            });
        });

    </script>


@endsection

