<?php

namespace App\Http\Controllers;

use App\Exports\BooksExport;
use App\Models\Book;
use App\Models\Bookshelf;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class BookController extends Controller
{
    public function index(Request $request)
{
 
    $query = $request->input('query', '');

   
    $books = Book::when($query, function ($queryBuilder) use ($query) {
        return $queryBuilder->where('title', 'like', '%' . $query . '%')
                             ->orWhere('author', 'like', '%' . $query . '%');
    })->paginate(5); 

 
    return view('books.index', compact('books', 'query'));
}

    


    public function create()
    {
        $data['bookshelves'] = Bookshelf::pluck('name', 'id');
        return view('books.create', $data);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'year' => 'required|max:2077',
            'publisher' => 'required|max:255',
            'city' => 'required|max:50',
            'cover' => 'required',
            'bookshelf_id' => 'required|max:5',
        ]);
        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->storeAs(
                'public/cover_buku',
                'cover_buku_' . time() . '.' . $request->file('cover')->extension()
            );
            $validated['cover'] = basename($path);
        }
        $book = Book::create($validated);
        if ($book) {
            $notification = array(
                'message' => 'Data buku berhasil disimpan',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Data buku gagal disimpan',
                'alert-type' => 'success'
            );
        }
        return redirect()->route('book')->with($notification);
    }

    public function edit($id){
        $data['book'] = Book::find($id);
        $data['bookshelves'] = Bookshelf::pluck('name','id');
        // dd($data);
        return view('books.edit', $data);
    }

    public function update( Request $request, $id){
        $dataLama = Book::find($id);
        $validated = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'year' => 'required|max:2077',
            'publisher' => 'required|max:255',
            'city' => 'required|max:50',
            'cover' => 'nullable|image',
            'bookshelf_id' => 'required|max:5',
        ]);
        if ($request->hasFile('cover')) {
            if($dataLama->cover != null){
                Storage::delete('public/cover_buku'. $request->old_cover);
            }
            $path = $request->file('cover')->storeAs(
                'public/cover_buku',
                'cover_buku_' . time() . '.' . $request->file('cover')->extension()
            );
            $validated['cover'] = basename($path);
        }
        $dataLama->update($validated);
        if ($dataLama) {
            $notification = array(
                'message' => 'Data buku berhasil disimpan',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Data buku gagal disimpan',
                'alert-type' => 'success'
            );
        }
        return redirect()->route('book')->with($notification);
    }


    public function destroy($id) {
        // $book = Book::find($id);
        // $book->delete();
        // return redirect()->route('book')->with(['message' => 'Data buku berhasil dihapus','alert-type' =>'success']);

        $data = Book::find($id);
        Storage::delete('public/cover_buku' .$data->cover);
        $berhasil = $data->delete();

        if($berhasil){
            $notification = array(
               'message' => 'Data buku berhasil dihapus',
                'alert-type' =>'success'
            );
        } else{
            $notification = array(
                'message' => 'Data buku gagal dihapus',
                'alert-type' => 'eror',
            );
        }
        return redirect()->route('book')->with($notification);
    }
    public function print(){
        $data['books'] = Book::all();
        $pdf = Pdf::loadView('books.print', $data);
        return $pdf->stream('DaftarBuku.pdf');
    }

    public function export(){
        return Excel::download(new BooksExport, 'book.xlsx');
    }
    

    public function search(Request $request)
{
    // Ambil query pencarian dari input user
    $query = $request->input('query');

    // Cari data buku berdasarkan query pencarian (judul atau penulis)
    if ($query) {
        $books = Book::where('title', 'like', "%{$query}%")
                     ->orWhere('author', 'like', "%{$query}%")
                     ->paginate(5);  // Gunakan paginate di sini
    } else {
        // Jika tidak ada query, ambil semua buku dengan pagination
        $books = Book::paginate(5);  // Gunakan paginate di sini juga
    }

    // Kirim data buku dan query ke view
    return view('books.index', compact('books', 'query'));
}


}