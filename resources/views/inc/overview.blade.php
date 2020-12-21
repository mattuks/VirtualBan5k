<div class="card bg-white rounded shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="text-left">
            <h2>{{auth()->user()->name}}</h2>
        </div>
        <div class="buttons d-flex">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                Open Account
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Open Account</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{route('open-account')}}" method="post">
                        <div class="modal-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    @csrf
                                    <label class="input-group-text" for="inputGroupSelect01">Options</label>
                                </div>
                                @csrf
                                <select class="custom-select" id="inputGroupSelect01" name="currency">
                                    <option selected>Choose what type of account you want...</option>
                                    <option value="USD">USD</option>
                                    <option value="EUR">EUR</option>
                                    <option value="GBP">GBP</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            @csrf
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" value="submit">Create Account</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="dropdown pl-2">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Change Account
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                </div>
            </div>
        </div>
    </div>
    <div class="card-body d-flex justify-content-between align-items-center">
        <div class="d-flex flex-column align-items-left ">
            <h4>{{$account->getCurrency()}} Account</h4>
            <p>Account Number: {{$account->getUUID()}}</p>
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex flex-column">
                <h1>{{$account->getAmount()}}</h1>
                <p class="text-right">{{$account->getCurrency()}}</p>
            </div>
            <div>
                <a href="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                         class="bi bi-chevron-compact-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                              d="M6.776 1.553a.5.5 0 0 1 .671.223l3 6a.5.5 0 0 1 0 .448l-3 6a.5.5 0 1 1-.894-.448L9.44 8 6.553 2.224a.5.5 0 0 1 .223-.671z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <div class="card-footer text-right">
        <a href="" class="btn btn-primary">Add Money</a>
        <a href="" class="btn btn-primary">Transfer</a>
    </div>
</div>
