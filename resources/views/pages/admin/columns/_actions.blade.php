<div class="d-flex">
    <a class="has_action badge rounded-pill text-bg-primary" style="--bs-bg-opacity: .2;" href="#" data-type="show"
       data-action="{{ route('admin.show',$model->id) }}" data-method="get">
        <i class="fa-regular fa-eye  text-primary"></i>
    </a>
    <a class="has_action badge rounded-pill text-bg-warning" style="--bs-bg-opacity: .2;" href="#" data-type="edit"
       data-action="{{ route('admin.edit',$model->id) }}">
        <i class="fa-regular fa-eye  text-warning"></i>
    </a>
    </div>

