<div class="row">
    <div class="col-12 mt-3">
        <table class="table table-bordered" id="fileTbl">
            <thead>
                <tr>
                    <th scope="col">File</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($data['minute']->minuteDocuments[0]))
                    @foreach ($data['minute']->minuteDocuments as $document)
                        <tr>
                            <td>
                                <a href="/show-document/{{$document->file_path}}" target="_blank" rel="noopener noreferrer">{{$document->file_path}}</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                <tr>
                    <td class="text-center">NO FILE</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
