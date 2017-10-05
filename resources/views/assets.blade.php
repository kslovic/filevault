<div class="tablediv">
    @if(isset($message))
        <div class="alert alert-info alert-dismissible" id="phpAlert">
            <strong>
                {{$message}}
            </strong>
        </div>
    @endif
    <div class="alert alert-info alert-dismissible" id="myAlert">
        <strong id="message">Success!</strong>
    </div>
    <table class="table table-hover tablecustom">
        <thead class="tabhead">
        <tr>
            <th>#ID</th>
            <th>Title</th>
            <th>Mime-Type</th>
            <th>Size(B)</th>
            <th>Public</th>
            <th>Creation time</th>
            <th>Downloads</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody id="result">
        @if(isset($asset))
            @foreach($asset as $file)
                <tr class="rows">
                    <td>{{$file->aid}}</td>
                    <td>{{$file->title}}</td>
                    <td>{{$file->mime_type}}</td>
                    <td>{{number_format($file->size, 0, '.', ',')}}</td>
                    <td id="public{{$file->aid}}">{{$file->public}}</td>
                    <td>{{$file->pub_time}}</td>
                    <td id="download{{$file->aid}}">{{$file->downloaded}}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" id="menu1" type="button" data-toggle="dropdown">Action
                                <span class="caret"></span></button>
                            <a class="btn btn-primary editp" id="editp{{$file->aid}}" href="#" onclick="edit({{$file->aid}})"></a>
                            <input class="urlasset" id="urlasset{{$file->aid}}" name="urlasset" value="filevault.loc/download/{{$file->aid}}">
                            <button class="btn btn-primary urlasset" onclick="copyclip({{$file->aid}})" id="copy{{$file->aid}}" data-clipboard-target="#urlasset{{$file->aid}}">copy</button>
                            <ul class="dropdown-menu">
                                <li role="presentation"> <a role="menuitem"  onclick="editshow({{$file->aid.",'".$file->public."'"}})" href="#">Edit</a></li>
                                <li role="presentation"><a role="menuitem"  href="/download/{{$file->aid}}" onclick="downloadshow({{$file->aid}})">Download</a></li>
                                <li role="presentation"><a role="menuitem"  href="#" onclick="urlshow({{$file->aid}})"> Share</a></li>
                            </ul>
                        </div>
                      </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
<div class="paginationdiv">{{ $asset->links() }}</div>