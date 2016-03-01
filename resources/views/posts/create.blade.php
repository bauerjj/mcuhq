@extends('layouts.full')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/css/selectize.min.css" type="text/css"/>

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
            <div class="col-sm-11">
                <input required="required" value="{{ old('title') }}" placeholder="Enter title here" type="text" name = "title" class="form-control" id="title" />
            </div>
        </div>
        {{--<div class="form-group">
            <textarea name='body'class="form-control">{{ old('body') }}</textarea>
        </div>--}}
        <input type="hidden" name="body" id="body-text">

        <div id="editor">{{ old('body') }}</div>
        <br/>

        <div class="form-group">
        <label for="tags" class="col-sm-1 control-label">Tags </label>
        <div class="col-sm-11">
             <input required="no" value="{{ old('tags') }}" placeholder="Tags" type="text" name = "title"  id="tags"/>
            </div>
        </div>
        <div class="form-group">
            <label for="github" class="col-sm-1 control-label">Github </label>
            <div class="col-sm-11">
                <input required="no" value="{{ old('github') }}" placeholder="(optional) Github Link" type="text" name = "title" class="form-control" id="github" />

            </div>
        </div>
        <div class="form-group">
            <label for="topics" class="col-sm-1 control-label">Topic(s) </label>
            <div class="col-sm-11">
                <select id="topic-dropdown" multiple="multiple" id="topics">
                    <option value="cheese">Audio</option>
                    <option value="tomatoes">Networking</option>
                    <option value="mozarella">Mozzarella</option>
                    <option value="mushrooms">Mushrooms</option>
                    <option value="pepperoni">Pepperoni</option>
                    <option value="onions">Onions</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="title" class="col-sm-1 control-label">Source</label>
            <div class="col-sm-11">
                <div style="position:relative;">
                    <a class='btn btn-primary' href='javascript:;'>
                        Choose Zip File...
                        <input type="file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' name="file_source" size="40"  onchange='$("#upload-file-info").html($(this).val());'>
                    </a>
                    &nbsp;
                    <span class='label label-info' id="upload-file-info"></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="micro" class="col-sm-1 control-label">Micro(s) </label>
            <div class="col-sm-11">
                <select id="micro" multiple="multiple">
                    <optgroup label="Microchip">
                        <option value="1-1">All</option>
                        <option value="1-2" selected="selected">PIC10</option>
                        <option value="1-3" selected="selected">PIC12</option>
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
            <label for="compiler-assembler" class="col-sm-1 control-label">Compiler  Assembler </label>
            <div class="col-sm-11">
                    <select id="compiler-assembler" multiple="multiple" id="compiler-assembler">
                        <option value="cheese">Audio</option>
                        <option value="tomatoes">Networking</option>
                        <option value="mozarella">Mozzarella</option>
                        <option value="mushrooms">Mushrooms</option>
                        <option value="pepperoni">Pepperoni</option>
                        <option value="onions">Onions</option>
                    </select>
                </div>
            </div>
        </div>

        <br/>
        <input type="submit"  name='publish' class="btn btn-success btn-form" value = "Publish"/>
        <input type="submit"  name='save' class="btn btn-default btn-form" value = "Save Draft" />
        <br/>
        <br/>
        <br/>

    </form>

@endsection

@section('script')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/js/standalone/selectize.min.js"></script>

    <script>
        var tags = [
            {tag: 'dog'}, {tag: 'cat'}, {tag: 'girfaf'}, {tag: 'elephant'},{tag: 'tiger'}, {tag: 'moose'},{tag: 'duck'}, {tag: 'bird'},
        ]
        $('#tags').selectize({
            delimiter: ',',
            persist: false,
            valueField: 'tag',
            labelField: 'tag',
            searchField: 'tag',
            options: tags,
            create: function(input) {
                return {
                    tag: input
                }
            }
        });


        $('#topic-dropdown').multiselect({
            maxHeight: 200,
            dropUp: false,
            onChange: function(option, checked) {
                // Get selected options.
                var selectedOptions = $('#topic-dropdown option:selected');

                if (selectedOptions.length >= 4) {
                    // Disable all other checkboxes.
                    var nonSelectedOptions = $('#topic-dropdown option').filter(function() {
                        return !$(this).is(':selected');
                    });

                    var dropdown = $('#topic-dropdown').siblings('.multiselect-container');
                    nonSelectedOptions.each(function() {
                        var input = $('input[value="' + $(this).val() + '"]');
                        input.prop('disabled', true);
                        input.parent('li').addClass('disabled');
                    });
                }
                else {
                    // Enable all checkboxes.
                    var dropdown = $('#topic-dropdown').siblings('.multiselect-container');
                    $('#topic-dropdown option').each(function() {
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

    </script>


@endsection

