package main

import (
	"fmt"
	"image"
	_ "image/gif"
	_ "image/jpeg"
	"image/png"
	"os"

	"github.com/nfnt/resize"
)

func imageProcess() {
	imgOriginalFile, err := os.Open("example.jpg")
	if err == nil {
		defer imgOriginalFile.Close()
		imgOriginal, _, err := image.Decode(imgOriginalFile)
		if err == nil {
			imgPngFile, err := os.Create("original.png")
			imgOriginal := resize.Resize(256, 0, imgOriginal, resize.Lanczos3)
			if err == nil {
				defer imgPngFile.Close()
				png.Encode(imgPngFile, imgOriginal)
				fmt.Print("test")
			}

		}
	} else {
		fmt.Print(err)
	}

	/*m := image.NewRGBA(image.Rect(0, 0, 800, 600))
	draw.Draw(m, m.Bounds(), img1, image.Point{0, 0}, draw.Src)
	toimg, _ := os.Create("new.jpg")
	defer toimg.Close()
	jpeg.Encode(toimg, m, &jpeg.Options{jpeg.DefaultQuality})*/
}
