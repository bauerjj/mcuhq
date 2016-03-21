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
            <form action="/new-post" method="post" class="input-post form-vertical" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" >

                <div class="form-group">
                    <label for="title" class="control-label required">Title </label>

                        <input required="required" value="{{ old('title') }}" placeholder="Enter title here" type="text"
                               name="title" class="form-control" id="title"/>
                </div>
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
                    <label for="tags" class="control-label required">Tags (1 min, 6 max) </label>

                        <input value="{{ old('tags') }}" placeholder="Tags" type="text" name="tags" id="tags"/>
                </div>
                <div class="form-group">
                    <label for="more_info_link" class="control-label">Source Link </label>

                        <input value="{{ old('more_info_link') }}" placeholder="(Optional) More Info Link i.e. github" type="text"
                               name="more_info_link" class="form-control" id="more_info_link"/>

                </div>
                <div class="form-group">
                    <label for="topic-dropdown" class="control-label required">Category (1 min, 4 max) </label>
                    <input type="hidden" name="topics" id="topics-input" required="true">
                        <select id="topic-dropdown" multiple="multiple" class="form-control">
                            @foreach($categories as $cat)
                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                            @endforeach
                        </select>
                </div>
                        <br/>
                        <br/>

                <div class="form-group">
                    <label for="title" class="control-label">Main Picture (ideally 200px X 200px)</label>

                    <div class="">
                        <div style="position:relative;">
                            <a class='btn btn-primary' href='javascript:;'>
                                Choose Main Image File...
                                <input type="file"
                                       style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;'
                                       name="file_image" class="form-control" size="40" onchange='$("#upload-file-image").html($(this).val());'>
                            </a>
                            &nbsp;
                            <span class='label label-info' id="upload-file-image"></span>
                        </div>
                    </div>
                </div>

        </div>
                    <div class="clearfix hidden-md hidden-lg"></div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="title" class="control-label">Source</label>

                <div class="">
                    <div style="position:relative;">
                        <a class='btn btn-primary' href='javascript:;'>
                            Choose Zip File...
                            <input type="file"
                                   style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;'
                                   name="file_source" class="form-control" size="40" onchange='$("#upload-file-info").html($(this).val());'>
                        </a>
                        &nbsp;
                        <span class='label label-info' id="upload-file-info"></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="micro" class="control-label required">Micro </label>
                <input type="hidden" name="micro" id="micro-input">

                    <select id="micro"  class="form-control">
                        {{ $lastId = -1 }}
                        @foreach($mcus as $mcu)
                            @if($mcu->vendor->id != $lastId)
                                @if($lastId != -1)
                                    </optgroup>
                                    @endif
                                <optgroup label="{{$mcu->vendor->name}}">
                            @endif
                                    <option value="{{$mcu->id}}">{{$mcu->name}}</option>
                                    {{ $lastId = $mcu->vendor->id }}
                        @endforeach
                                </optgroup>
                    </select>
                </div>
            <br/>
            <br/>


            <div class="form-group">
                <label for="compiler-assembler" class="control-label required">Compiler Assembler</label>
                <input type="hidden" name="compiler-assembler required" id="compiler-assembler-input">

                    <select id="compiler-assembler"  class="form-control">
                        {{ $lastId = -1 }}
                        @foreach($compilers as $compiler)
                        @if($compiler->vendor->id != $lastId)
                        @if($lastId != -1)
                        </optgroup>
                        @endif
                        <optgroup label="{{$compiler->vendor->name}}">
                            @endif
                            <option value="{{$compiler->id}}">{{$compiler->name}}</option>
                        {{ $lastId = $compiler->vendor->id }}
                        @endforeach
                    </select>
            </div>
            <br/>
            <br/>


            <div class="form-group">
                <label for="language-dropdown" class="control-label">Language (optional, 3 max) </label>
                <input type="hidden" name="languages" id="language-input">

                    <select id="languages" multiple="multiple form-control">
                        @foreach($languages as $language)
                            <option value="{{$language->id}}">{{$language->name}}</option>
                        @endforeach
                    </select>
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

    <script src="//cdnjs.cloudflare.com/ajax/libs/ace/1.1.3/ace.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/marked/0.3.2/marked.min.js"></script>
    {!! Minify::javascript("/bower_components/bootstrap-markdown-editor/dist/js/bootstrap-markdown-editor.js") !!}



    <script>
        var i;
//        var tags = [
//            {tag: 'dog'}, {tag: 'cat'}, {tag: 'girfaf'}, {tag: 'elephant'}, {tag: 'tiger'}, {tag: 'moose'}, {tag: 'duck'}, {tag: 'bird'},
//        ]
        var tags ={!!$tags!!}

        var $tagSelect = $('#tags').selectize({
            plugins: ['remove_button'],
            delimiter: ',',
            persist: false,
//            valueField: 'tag',
//            labelField: 'tag',
//            searchField: 'tag',
            valueField: 'slug',
            labelField: 'slug',
            searchField: 'slug',
            maxItems: 6,
            options: tags,
            create: function (input) {
                return {
                    slug: input
                }
            }
        });
        // Get the instance via the first element
        // If you want to add more than one element, pass in an array
        // with the key of 'slug' that matches 'slug' in the methods of the
        // above $tagSelect
        var selectize = $tagSelect[0].selectize;
        var tagArray = '{{old('tags')}}'.split(',');
        var defaultArray = [];
        var valueArray = [];
        var i;
        for (i = 0; i < tagArray.length; i++) {
            defaultArray.push({slug: tagArray[i]})
            valueArray.push(tagArray[i])
        }
        //$tagSelect[0].selectize.addOption([{slug: 'yep'}, {slug: 'weroeurwer'}])
        $tagSelect[0].selectize.addOption(defaultArray)
        //$tagSelect[0].selectize.setValue(['yep','weroeurwer'])
        $tagSelect[0].selectize.setValue(valueArray)

        // Any multiple values must be assigned back using this method
        var mcuArray = '{{old('micro')}}'.split(',');
        $('#micro').val(mcuArray)
        var compilerArray = '{{old('compiler-assembler')}}'.split(',');
        $('#compiler-assembler').val(compilerArray)
        var languagesArray = '{{old('languages')}}'.split(',');
        $('#languages').val(languagesArray)
        var categoriesArray = '{{old('topics')}}'.split(',');
        $('#topic-dropdown').val(categoriesArray)







        $('#languages').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200,
            dropUp: true,
            onChange: function (option, checked) {
                // Get selected options.
                var selectedOptions = $('#languages option:selected');

                if (selectedOptions.length >= 3) {
                    // Disable all other checkboxes.
                    var nonSelectedOptions = $('#languages option').filter(function () {
                        return !$(this).is(':selected');
                    });

                    var dropdown = $('#languages').siblings('.multiselect-container');
                    nonSelectedOptions.each(function () {
                        var input = $('input[value="' + $(this).val() + '"]');
                        input.prop('disabled', true);
                        input.parent('li').addClass('disabled');
                    });

                }
                else {
                    // Enable all checkboxes.
                    var dropdown = $('#languages').siblings('.multiselect-container');
                    $('#languages option').each(function () {
                        var input = $('input[value="' + $(this).val() + '"]');
                        input.prop('disabled', false);
                        input.parent('li').addClass('disabled');
                    });
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
            enableCollapsibleOptGroups: true,
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

        $('#editor').markdownEditor('setContent','{{ old('body') }}') // NEED THIS to repopluate form if errors!

        // Can't repopluate!
        //$("#upload-file-info").html('{{old('file_source')}}')
        //$("#upload-file-image").val('{{old('file_image')}}')


        $(function () {
            $('.btn-form').click(function () { // enter here if publishing or drafting
                var mysave = $('#editor').markdownEditor('content')
                $('#body-text').val(mysave);
                $('#compiler-assembler-input').val($('#compiler-assembler').val())
                $('#micro-input').val($('#micro').val())
                $('#topics-input').val($('#topic-dropdown').val())
                $('#language-input').val($('#languages').val())


            });
        });

    </script>

    <script>
        // So to make any large images fit inside viewing area
        $( ".main-content img" ).addClass( "img-responsive" );

    </script>


@endsection

