import { useState } from "react";
import AuthUser from "./AuthUser";

export default function Login(){
    const {http} = AuthUser();
    const [client_id,setClientId] = useState();
    const [client_secret,setClientSecret] = useState();
    const [redirect_uri,setRedirectUri] = useState();
    // const [c_password,setConfirmPassword] = useState();

    const submitFrom = () => {
        console.log(client_id + " " + client_secret + " " + redirect_uri);

        
        http.post('/register', {client_id:client_id, client_secret:client_secret, redirect_uri:redirect_uri})
            .then((res)=>{
                console.log(res.data)
                window.location.replace(res.data);
            })
    }
    return(
        <div className="row justify-content-center pt-5">
            <div className="col-sm-6">
                <div className="card p-4">
                    <div className="form-group">
                        <label>ZOHO_CLIENT_ID:</label>
                        <input type="text" className="form-control" id="client_id" onChange={e => setClientId(e.target.value)} />
                    </div>
                    <div className="form-group">
                        <label>ZOHO_CLIENT_SECRET:</label>
                        <input type="text" className="form-control" id="client_secret" onChange={e => setClientSecret(e.target.value)} />
                    </div>
                    <div className="form-group">
                        <label>ZOHO_REDIRECT_URI:</label>
                        <input type="text" className="form-control" id="redirect_uri" onChange={e => setRedirectUri(e.target.value)} />
                    </div>
                    {/* <div className="form-group">
                        <label>Confirm Password:</label>
                        <input type="password" className="form-control" id="confirm_pwd" onChange={e => setConfirmPassword(e.target.value)} />
                    </div> */}
                    
                    <button onClick={submitFrom} type="button" className="btn btn-primary mt-4">Submit</button>
                </div>
            </div>
        </div>
    )
}