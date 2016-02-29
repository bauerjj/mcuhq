@extends('layouts.full')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" type="text/css"/>
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
    <form action="/new-post" method="post" class="input-post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <input required="required" value="{{ old('title') }}" placeholder="Enter title here" type="text" name = "title"class="form-control" />

        </div>
        {{--<div class="form-group">
            <textarea name='body'class="form-control">{{ old('body') }}</textarea>
        </div>--}}
        <input type="hidden" name="body" id="body-text">

        <div id="editor">{{ old('body') }}</div>
        <br/>


        <input required="no" value="{{ old('tags') }}" placeholder="Tags" type="text" name = "title"class="form-control" />
        <input required="no" value="{{ old('github') }}" placeholder="(optional) Github Link" type="text" name = "title"class="form-control" />
        <select id="topic-dropdown" multiple="multiple">
            <option value="cheese">Audio</option>
            <option value="tomatoes">Networking</option>
            <option value="mozarella">Mozzarella</option>
            <option value="mushrooms">Mushrooms</option>
            <option value="pepperoni">Pepperoni</option>
            <option value="onions">Onions</option>
        </select>

        <div style="position:relative;">
            <a class='btn btn-primary' href='javascript:;'>
                Choose File...
                <input type="file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' name="file_source" size="40"  onchange='$("#upload-file-info").html($(this).val());'>
            </a>
            &nbsp;
            <span class='label label-info' id="upload-file-info"></span>
        </div>

        <select id="example-enableFiltering-optgroups" multiple="multiple">
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


        <br/>
        <input type="submit"  name='publish' class="btn btn-success btn-form" value = "Publish"/>
        <input type="submit"  name='save' class="btn btn-default btn-form" value = "Save Draft" />

    </form>

@endsection

@section('script')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>

    <script>
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

        $('#example-enableFiltering-optgroups').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200,
            dropUp: true
        });

    </script>


@endsection

