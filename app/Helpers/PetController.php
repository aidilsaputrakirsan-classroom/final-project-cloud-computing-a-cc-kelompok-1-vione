use App\Helpers\LogActivity;

public function store(Request $request)
{
    $pet = Pet::create($request->all());

    LogActivity::add('Create Pet', 'User menambahkan hewan baru: ' . $pet->name);

    return redirect()->back()->with('success', 'Pet created.');
}
