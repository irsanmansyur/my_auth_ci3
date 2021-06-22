import Axios from 'axios';
import React, { useState } from 'react';
import ReactDOM from 'react-dom';
import Spinner from '../Spinner';

const ImgProfile = ({ endpoint, imageState }) => {
  const [file, setFile] = useState(null);
  const [image, setImage] = useState(imageState);
  const [imageLoading, setImageLoading] = useState(false);
  const changeThumbnail = (e) => {
    setFile(e.target.files[0])
  }
  const uploadImg = async () => {
    const data = new FormData();
    data.append("thumbnail", file);
    setImageLoading(true);
    try {
      let res = await Axios.post(endpoint, data);
      if (res.data.status) {
        setImage(URL.createObjectURL(file));
        setFile(null);
      }
    } catch (e) {
      console.log(e.response);
    }
    setImageLoading(false);
  }
  return (
    <div className="text-center">
      {imageLoading ? <Spinner /> :
        <img className="img-account-profile rounded-circle mb-2" src={file ? URL.createObjectURL(file) : image} alt={file ? file.name : image} alt="" />
      }

      <div className="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>

      <input type="file" name="thumbnail" id="thumbnail" accept="image/*" className="d-none" style={{ display: "none" }} onChange={changeThumbnail} />

      {file ?
        <div className="text-center">
          <span className="btn btn-success mb-1" onClick={uploadImg}>Save Change</span><br />
          <span className="btn btn-danger my-1" onClick={e => setFile(null)}>Cancel</span><br />
        </div>
        : <label htmlFor="thumbnail">
          <span className="btn btn-primary">Upload new image</span>
        </label>
      }
    </div>
  );
};

export default ImgProfile;
if (document.querySelector('#imgUpload')) {
  let imageUpload = document.querySelector('#imgUpload');
  ReactDOM.render(<ImgProfile endpoint={imageUpload.getAttribute("endpoint")} imageState={imageUpload.getAttribute("image")} />, imageUpload);
}