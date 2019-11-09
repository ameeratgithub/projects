@if ($entities->lastPage() > 1)
    <ul class="pagination center-align">
        <li class="{{ ($entities->currentPage() == 1) ? ' disabled' : '' }}">
            <a href="{{($entities->currentPage() == 1) ? 'javascript:void(0)' :
                         $entities->url(1) }}">
                <i class="material-icons">first_page</i>
            </a>
        </li>
        <li class="{{ ($entities->currentPage() == 1) ? ' disabled' : '' }}">
            <a href="{{($entities->currentPage() == 1) ? 'javascript:void(0)' :
                         $entities->url($entities->currentPage()-1) }}">
                <i class="material-icons">chevron_left</i>
            </a>
        </li>
        @for ($i = 1; $i <= $entities->lastPage(); $i++)
            <li class="{{ ($entities->currentPage() == $i) ? ' active' : '' }}">
                <a href="{{ $entities->url($i) }}" class="waves-effect">{{ $i }}</a>
            </li>
        @endfor
        <li class="{{ ($entities->currentPage() == $entities->lastPage()) ? ' disabled' : '' }}">
            <a href="{{($entities->currentPage() == $entities->lastPage()) ? 'javascript:void(0)' :
                         $entities->url($entities->currentPage()+1) }}" ><i class="material-icons">chevron_right</i></a>
        </li>
        <li class="{{ ($entities->currentPage() == $entities->lastPage()) ? ' disabled' : '' }}">
            <a href="{{($entities->currentPage() == $entities->lastPage()) ? 'javascript:void(0)' :
                         $entities->url($entities->lastPage())}}"><i class="material-icons">last_page</i></a>
        </li>
    </ul>
@endif