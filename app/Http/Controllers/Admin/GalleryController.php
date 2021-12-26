<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductGalleryRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class GalleryController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = ProductGallery::with(['product']);

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle mr-1 mb-1" 
                                    type="button" id="action' .  $item->id . '"
                                        data-toggle="dropdown" 
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        Aksi
                                </button>
                                <div class="dropdown-menu" aria-labelledby="action' .  $item->id . '">
                                    <form action="' . route('galleries.destroy', $item->id) . '" method="POST">
                                        ' . method_field('delete') . csrf_field() . '
                                        <button type="submit" class="dropdown-item text-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                    </div>';
                })
                ->editColumn('photos',function($item){
                    return  $item->photos ? '<img src="'. Storage::url($item->photos) .'" style="max-height:80px;" />' : '';
                })
                ->rawColumns(['action','photos'])
                ->make();
        }

        return view('pages.admin.galleries.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.galleries.create',[
            'products' => Product::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductGalleryRequest $request)
    {
        $data             = $request->all();

        $data['photos'] = $request->file('photos')->store('assets/products','public');
        
        ProductGallery::create($data);

        return redirect()->route('galleries.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = ProductGallery::findOrFail($id);
        $item->delete();

        return redirect()->route('galleries.index');
    }
}
