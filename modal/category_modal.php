<div id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div role="document">
        <div>
            <div>
                <h5 id="exampleModalLabel">Modal Title </h5>
                <button type=button data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">

                <div>

                    <div>
                        <label for="exampleInputEmail1">Course Id</label>
                        <input type=text id="id" name=id required>
                    </div>
                    <div>
                        <label for="exampleInputEmail1">Enter Course Name</label>
                        <input type=text id="name" name=name required>
                    </div>
                    <div>
                        <label for="exampleInputEmail1">Enter Course Duration <small> (In hours)</small> </label>
                        <input type=text id="duration" name=duration value="" required>
                    </div>
                    <div>
                        <label for="exampleInputEmail1">Date </label>
                        <input type=text id="date" name=date value="" required>
                    </div>
                </div>
                <div>
                    <button type=button data-dismiss="modal">Close</button>
                    <button type=submit>Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>