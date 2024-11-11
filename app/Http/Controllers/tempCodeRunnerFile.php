<?php

namespace App\Http\Controllers;

use App\Models\Product; // Import the Product model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
// use Illuminate\Http\Request;


class ProductController extends Controller
{
    //
    public function index()
    {
        $products = Product::all();

        // dd($products);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        // Validate the file and other fields
        $validatedData = $request->validate([
            'Name' => 'required|string|max:255',
            'Price' => 'required|numeric',
            // 'Description' => 'nullable|string|max:1000',
            'Photo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
    
        if ($request->hasFile('Photo') && $request->file('Photo')->isValid()) {
            // Retrieve the file from the request
            $Photo = $request->file('Photo');
            
            // Move the file to the public directory before hashing
            $fileName = $Photo->hashName();
            $Photo->move(public_path(), $fileName);
    
            // Store the product data with the new image path
            Product::create([
                'Name' => $request->Name,
                'Price' => $request->Price,
                // 'Description' => $request->Description,
                'Photo' => $fileName  // Save the new filename
            ]);
    
            return redirect()->route('products.index')->with('success', 'Product added successfully!');
        } else {
            return redirect()->back()->withErrors('File upload failed. Please try again.');
        }
    }
    
    
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }
    public function update(Request $request, Product $product)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'Name' => 'required|string|max:255',
            'Price' => 'required|numeric',
            // 'Description' => 'nullable|string|max:1000',
            'Photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
    
        // Update product details
        $product->Name = $validatedData['Name'];
        $product->Price = str_replace(".", "", $validatedData['Price']);
        // $product->Description = $validatedData['Description'];
    
        // Handle photo upload if a new one was uploaded
        if ($request->hasFile('Photo')) {
            // Delete the old photo if it's not the default "noimage.png"
            if ($product->Photo != "noimage.png") {
                $oldImagePath = public_path($product->Photo);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);  // Delete the old image from the public directory
                }
            }
    
            // Store the new photo directly in the 'public_html' directory
            $Photo = $request->file('Photo');
            $newPhotoName = time() . '_' . $Photo->getClientOriginalName(); // Generate a unique name for the photo
            $Photo->move(public_path(), $newPhotoName);
            $product->Photo = $newPhotoName; // Save the new photo name in the database
        }
    
        // Save the updated product information
        $product->save();
    
        // Redirect with success message
        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }
    
    
    
    public function destroy(Product $product)
    {
        // Check if the product's photo is not the default "noimage.png"
        if ($product->Photo != "noimage.png") {
            // Delete the photo from the 'public' folder
            $imagePath = public_path($product->Photo);
            if (file_exists($imagePath)) {
                unlink($imagePath);  // Delete the image file from the public directory
            }
        }
    
        // Delete the product record from the database
        $product->delete();
    
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
    
    

    public function export() 
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

    public function import(Request $request) 
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv'
        ]);

        Excel::import(new ProductsImport, $request->file('file')->store('temp'));

        return redirect()->route('products.index')->with('success', 'Products imported successfully!');
    }

    public function exportActivityLog()
    {
        // Fetch the products data
        $products = Product::all();
    
        // Define log content
        $logContent = "Product Activity Log\n\n";
        foreach ($products as $product) {
            $logContent .= "Product Name: {$product->Name}\n";
            $logContent .= "Price: {$product->Price}\n";
            $logContent .= "Description: {$product->Description}\n";
            $logContent .= "Photo: {$product->Photo}\n";
            $logContent .= "Created At: {$product->created_at}\n";
            $logContent .= "Updated At: {$product->updated_at}\n";
            $logContent .= "-------------------------\n";
        }
    
        // Set the filename
        $fileName = "product_activity_log.txt";
    
        // Create and return the download response
        return response($logContent)
                ->header('Content-Type', 'text/plain')
                ->header('Content-Disposition', "attachment; filename=$fileName");
    }
    
}